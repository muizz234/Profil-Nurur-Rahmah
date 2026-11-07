<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeritaController extends Controller
{
    use HandlesUploads;

    /**
     * Display a listing of the news articles.
     */
    public function index(): View
    {
        $beritas = Berita::with(['category', 'user'])
            ->latest('id')
            ->paginate(10);

        return view('admin.berita.index', [
            'beritas' => $beritas,
        ]);
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        return view('admin.berita.create', [
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Store a newly created article.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBerita($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => $request->user()->id,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $this->resolvePublishedAt($request),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'), 'berita');
        }

        Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified article.
     */
    public function show(Berita $berita): View
    {
        $berita->load(['category', 'user']);

        return view('admin.berita.show', [
            'berita' => $berita,
        ]);
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', [
            'berita' => $berita,
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Update the specified article.
     */
    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $validated = $this->validateBerita($request);

        $data = [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $berita->id),
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $this->resolvePublishedAt($request),
        ];

        if ($request->hasFile('image')) {
            $this->deleteImage($berita->image);
            $data['image'] = $this->storeImage($request->file('image'), 'berita');
        }

        $berita->update($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified article.
     */
    public function destroy(Berita $berita): RedirectResponse
    {
        $this->deleteImage($berita->image);

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Validate the article request.
     *
     * @return array<string, mixed>
     */
    private function validateBerita(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * Resolve the publication timestamp based on the request state.
     */
    private function resolvePublishedAt(Request $request): ?Carbon
    {
        if (! $request->boolean('is_published')) {
            return null;
        }

        return $request->filled('published_at')
            ? $request->date('published_at')
            : now();
    }

    /**
     * Build a unique slug for the article.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (
            Berita::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    /**
     * Available news categories.
     *
     * @return Collection<int, Category>
     */
    private function categories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }
}
