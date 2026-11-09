<?php

namespace App\Http\Requests\Admin;

use App\Support\ContentSupport;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKegiatanRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', Rule::in(array_keys(ContentSupport::kegiatanCategoryOptions()))],
            'icon_or_image' => ContentSupport::imageRules(),
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
