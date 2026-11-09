<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriRequest;
use App\Http\Requests\Admin\UpdateGaleriRequest;
use App\Models\Category;
use App\Models\Galeri;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GaleriController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        $galeris = Galeri::query()->with('category')->latest('id')->paginate(12);

        return view('admin.galeri.index', [
            'galeris' => $galeris,
        ]);
    }

    public function create(): View
    {
        return view('admin.galeri.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(StoreGaleriRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Galeri::create([
            'title' => $validated['title'],
            'image_path' => $this->storeImage($request->file('image'), 'galeri'),
            'caption' => $validated['caption'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri): View
    {
        return view('admin.galeri.edit', [
            'galeri' => $galeri,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateGaleriRequest $request, Galeri $galeri): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImage($galeri->image_path);
            $data['image_path'] = $this->storeImage($request->file('image'), 'galeri');
        }

        $galeri->update($data);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri): RedirectResponse
    {
        $this->deleteImage($galeri->image_path);

        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
