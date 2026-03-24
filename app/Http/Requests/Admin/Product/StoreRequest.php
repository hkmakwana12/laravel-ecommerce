<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'max:255', Rule::unique(Product::class)],
            'short_description' => ['nullable', 'string'],
            'long_description'  => ['nullable', 'string'],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'brand_id'          => ['nullable', 'exists:brands,id'],

            'is_featured'       => ['boolean'],
        ];
    }
}
