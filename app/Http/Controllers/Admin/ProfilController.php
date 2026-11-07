<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:1000'],
            'hero_year' => ['required', 'string', 'max:10'],
            'target_juz' => ['required', 'string', 'max:10'],
            'total_santri' => ['required', 'string', 'max:10'],
            'total_pengajar' => ['required', 'string', 'max:10'],
            'history' => ['required', 'string'],
            'vision' => ['required', 'string'],
            'missions' => ['required', 'string'],
            'leader_name' => ['required', 'string', 'max:255'],
            'leader_title' => ['required', 'string', 'max:255'],
            'leader_quote' => ['required', 'string'],
            'leader_since' => ['required', 'string', 'max:255'],
            'leader_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'site_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        ]);

        $missions = $this->parseMissions($validated['missions']);

        $settings = collect($validated)
            ->except(['leader_photo', 'site_logo'])
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
