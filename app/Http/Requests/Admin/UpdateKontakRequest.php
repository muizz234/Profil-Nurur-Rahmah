<?php

namespace App\Http\Requests\Admin;

use App\Support\ContentSupport;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKontakRequest extends FormRequest
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
            'address' => ['required', 'string'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'operational_hours' => ['required', 'string', 'max:255'],
            'maps_embed' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if (ContentSupport::extractGoogleMapsUrl((string) $value) === null) {
                        $fail('URL peta harus berupa URL Google Maps (google.com/maps atau google.com/maps/embed).');
                    }
                },
            ],
        ];
    }
}
