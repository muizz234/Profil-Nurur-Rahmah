<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    use HandlesUploads;

    /**
     * Display a listing of the activities.
     */
    public function index(): View
    {
        $kegiatans = Kegiatan::query()->latest('id')->paginate(10);

        return view('admin.kegiatan.index', [
            'kegiatans' => $kegiatans,
        ]);
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(): View
    {
        return view('admin.kegiatan.create', [
            'categories' => $this->categoryOptions(),
        ]);
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateKegiatan($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon_or_image')) {
            $data['icon_or_image'] = $this->storeImage($request->file('icon_or_image'), 'kegiatan');
        }

        Kegiatan::create($data);

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Kegiatan $kegiatan): View
    {
        return view('admin.kegiatan.edit', [
            'kegiatan' => $kegiatan,
            'categories' => $this->categoryOptions(),
        ]);
    }

    /**
     * Update the specified activity.
     */
    public function update(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        $validated = $this->validateKegiatan($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $kegiatan->id),
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('icon_or_image')) {
            $this->deleteImage($kegiatan->icon_or_image);
            $data['icon_or_image'] = $this->storeImage($request->file('icon_or_image'), 'kegiatan');
        }

        $kegiatan->update($data);

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        $this->deleteImage($kegiatan->icon_or_image);

        $kegiatan->delete();

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Validate the activity request.
     *
     * @return array<string, mixed>
     */
    private function validateKegiatan(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', Rule::in(array_keys($this->categoryOptions()))],
            'icon_or_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Build a unique slug for the activity.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (
            Kegiatan::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    /**
     * Available activity categories.
     *
     * @return array<string, string>
     */
    private function categoryOptions(): array
    {
        return [
            'tahfidz' => 'Tahfidz',
            'kitab_kuning' => 'Kitab Kuning',
            'formal' => 'Pendidikan Formal',
            'ekstrakurikuler' => 'Ekstrakurikuler',
        ];
    }
}
