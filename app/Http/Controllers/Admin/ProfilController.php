<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfilRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilController extends Controller
{
    use HandlesUploads;

    /**
     * Display the profile settings form.
     */
    public function index(): View
    {
        $settings = array_merge(config('site.defaults'), SiteSetting::allAsArray());

        return view('admin.profil.index', [
            'settings' => $settings,
            'missions' => $this->parseMissions($settings['missions'] ?? null),
        ]);
    }

    /**
     * Update the profile settings.
     */
    public function update(UpdateProfilRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $missions = $this->parseMissions($validated['missions']);

        $settings = collect($validated)
            ->except(['leader_photo', 'site_logo', 'hero_background_image'])
            ->map(fn (mixed $value): mixed => is_string($value) ? trim($value) : $value)
            ->all();

        $settings['missions'] = implode("\n", $missions);

        if ($request->hasFile('leader_photo')) {
            $this->deleteImage(SiteSetting::get('leader_photo'));
            $settings['leader_photo'] = $this->storeImage($request->file('leader_photo'), 'profil');
        }

        if ($request->hasFile('site_logo')) {
            $logo = $this->storeImage($request->file('site_logo'), 'logos');
            $this->deleteImage(SiteSetting::get('site_logo'));
            $settings['site_logo'] = $logo;
        }

        if ($request->hasFile('hero_background_image')) {
            $background = $this->storeImage($request->file('hero_background_image'), 'hero');
            $this->deleteImage(SiteSetting::get('hero_background_image'));
            $settings['hero_background_image'] = $background;
        }

        SiteSetting::setMany($settings);

        return redirect()
            ->route('admin.profil.index')
            ->with('success', 'Profil pesantren berhasil diperbarui.');
    }

    /**
     * Normalise the missions value into a clean list of lines.
     *
     * @return array<int, string>
     */
    private function parseMissions(mixed $missions): array
    {
        if (is_array($missions)) {
            return array_values(array_filter($missions, fn (mixed $item): bool => filled($item)));
        }

        if (is_string($missions) && trim($missions) !== '') {
            return collect(preg_split('/\r\n|\r|\n/', $missions))
                ->map(fn (string $mission): string => trim($mission))
                ->filter()
                ->values()
                ->all();
        }

        return [];
    }
}
