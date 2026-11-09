<?php

namespace App\Http\Requests\Admin;

use App\Support\ContentSupport;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
            'leader_photo' => ContentSupport::imageRules(),
            'site_logo' => ContentSupport::imageRules(),
            'hero_background_image' => ContentSupport::imageRules(),
        ];
    }
}
