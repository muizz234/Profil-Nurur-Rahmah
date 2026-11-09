<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateKontakRequest;
use App\Models\SiteSetting;
use App\Support\ContentSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KontakController extends Controller
{
    public function index(): View
    {
        $settings = array_merge(config('site.defaults'), SiteSetting::allAsArray());

        return view('admin.kontak.index', [
            'settings' => $settings,
        ]);
    }

    public function update(UpdateKontakRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        SiteSetting::setMany([
            'address' => trim($validated['address']),
            'whatsapp' => trim($validated['whatsapp']),
            'email' => trim($validated['email']),
            'operational_hours' => trim($validated['operational_hours']),
            'maps_embed' => ContentSupport::extractGoogleMapsUrl($validated['maps_embed']),
        ]);

        return redirect()
            ->route('admin.kontak.index')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}
