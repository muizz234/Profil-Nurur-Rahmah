<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KontakController extends Controller
{
    /**
     * Display the contact settings form.
     */
    public function index(): View
    {
        $settings = array_merge(config('site.defaults'), SiteSetting::allAsArray());

        return view('admin.kontak.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the contact settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address' => ['required', 'string'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'operational_hours' => ['required', 'string', 'max:255'],
            'maps_embed' => ['required', 'string'],
        ]);

        SiteSetting::setMany([
            'address' => trim($validated['address']),
            'whatsapp' => trim($validated['whatsapp']),
            'email' => trim($validated['email']),
            'operational_hours' => trim($validated['operational_hours']),
            'maps_embed' => $this->extractMapsSrc($validated['maps_embed']),
        ]);

        return redirect()
            ->route('admin.kontak.index')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }

    /**
     * Extract the embed URL from a Google Maps iframe or plain URL.
     */
    private function extractMapsSrc(string $value): string
    {
        $value = trim($value);

        if (preg_match('/<iframe[^>]*\ssrc=["\']([^"\']+)["\']/i', $value, $matches)) {
            return html_entity_decode($matches[1]);
        }

        return $value;
    }
}
