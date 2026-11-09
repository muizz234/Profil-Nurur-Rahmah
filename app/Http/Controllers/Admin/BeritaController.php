<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Models\Berita;
use App\Models\Category;
use App\Support\ContentSupport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class BeritaController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        $beritas = Berita::with(['category', 'user'])
            ->latest('id')
            ->paginate(10);

        return view('admin.berita.index', [
            'beritas' => $beritas,
        ]);
    }

    public function create(): View
    {
        return view('admin.berita.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => $request->user()->id,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $this->resolvePublishedAt($request),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'), 'berita');
        }

        ContentSupport::retryOnDuplicateSlug(function () use ($data, $validated) {
            Berita::create([
                ...$data,
                'slug' => ContentSupport::uniqueSlug(Berita::class, $validated['title']),
            ]);
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $berita): View
    {
        $berita->load(['category', 'user']);

        return view('admin.berita.show', [
            'berita' => $berita,
        ]);
    }

    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', [
            'berita' => $berita,
            'categories' => $this->categories(),
        ]);
    }

    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'is_published' => $request->boolean('is_published'),
            'published_at' => $this->resolvePublishedAt($request),
        ];

        if ($request->hasFile('image')) {
            $this->deleteImage($berita->image);
            $data['image'] = $this->storeImage($request->file('image'), 'berita');
        }

        ContentSupport::retryOnDuplicateSlug(function () use ($berita, $data, $validated) {
            $berita->update([
                ...$data,
                'slug' => ContentSupport::uniqueSlug(Berita::class, $validated['title'], $berita->id),
            ]);
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        $this->deleteImage($berita->image);

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function resolvePublishedAt(StoreBeritaRequest|UpdateBeritaRequest $request): ?Carbon
    {
        if (! $request->boolean('is_published')) {
            return null;
        }

        return $request->filled('published_at')
            ? $request->date('published_at')
            : now();
    }

    /**
     * @return Collection<int, Category>
     */
    private function categories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }
}
