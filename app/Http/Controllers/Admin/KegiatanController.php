<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKegiatanRequest;
use App\Http\Requests\Admin\UpdateKegiatanRequest;
use App\Models\Kegiatan;
use App\Support\ContentSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        $kegiatans = Kegiatan::query()->latest('id')->paginate(10);

        return view('admin.kegiatan.index', [
            'kegiatans' => $kegiatans,
        ]);
    }

    public function create(): View
    {
        return view('admin.kegiatan.create', [
            'categories' => ContentSupport::kegiatanCategoryOptions(),
        ]);
    }

    public function store(StoreKegiatanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon_or_image')) {
            $data['icon_or_image'] = $this->storeImage($request->file('icon_or_image'), 'kegiatan');
        }

        ContentSupport::retryOnDuplicateSlug(function () use ($data, $validated) {
            Kegiatan::create([
                ...$data,
                'slug' => ContentSupport::uniqueSlug(Kegiatan::class, $validated['title']),
            ]);
        });

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan): View
    {
        return view('admin.kegiatan.edit', [
            'kegiatan' => $kegiatan,
            'categories' => ContentSupport::kegiatanCategoryOptions(),
        ]);
    }

    public function update(UpdateKegiatanRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon_or_image')) {
            $this->deleteImage($kegiatan->icon_or_image);
            $data['icon_or_image'] = $this->storeImage($request->file('icon_or_image'), 'kegiatan');
        }

        ContentSupport::retryOnDuplicateSlug(function () use ($kegiatan, $data, $validated) {
            $kegiatan->update([
                ...$data,
                'slug' => ContentSupport::uniqueSlug(Kegiatan::class, $validated['title'], $kegiatan->id),
            ]);
        });

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        $this->deleteImage($kegiatan->icon_or_image);

        $kegiatan->delete();

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
