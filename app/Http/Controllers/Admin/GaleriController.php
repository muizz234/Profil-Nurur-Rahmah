<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriController extends Controller
{
    use HandlesUploads;

    /**
     * Display a listing of the gallery items.
     */
    public function index(): View
    {
        $galeris = Galeri::query()->latest('id')->paginate(12);

        return view('admin.galeri.index', [
            'galeris' => $galeris,
        ]);
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create(): View
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        Galeri::create([
            'title' => $validated['title'],
            'image_path' => $this->storeImage($request->file('image'), 'galeri'),
            'caption' => $validated['caption'] ?? null,
            'category' => $validated['category'] ?? null,
        ]);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Galeri $galeri): View
    {
        return view('admin.galeri.edit', [
            'galeri' => $galeri,
        ]);
    }

    /**
     * Update the specified gallery item.
     */
    public function update(Request $request, Galeri $galeri): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = [
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'category' => $validated['category'] ?? null,
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

    /**
     * Remove the specified gallery item.
     */
    public function destroy(Galeri $galeri): RedirectResponse
    {
        $this->deleteImage($galeri->image_path);

        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
