<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name'              => ['required', 'string', 'max:200'],
            'slug'              => ['nullable', 'string', 'max:220', 'unique:products,slug'.($productId ? ','.$productId : '')],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'subcategory_id'    => ['nullable', 'exists:categories,id'],
            'sku'               => ['nullable', 'string', 'max:100', 'unique:products,sku'.($productId ? ','.$productId : '')],
            'price'             => ['required', 'numeric', 'min:0', 'max:999999'],
            'sale_price'        => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'description'       => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'full_description'  => ['nullable', 'string'],
            'ingredients'       => ['nullable', 'string'],
            'nutritional_info'  => ['nullable', 'string'],
            'allergens'         => ['nullable', 'string', 'max:500'],
            'image'             => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            'gallery_images'    => ['nullable', 'array', 'max:10'],
            'gallery_images.*'  => ['image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'is_active'         => ['nullable', 'boolean'],
            'is_featured'       => ['nullable', 'boolean'],
            'is_bestseller'     => ['nullable', 'boolean'],
            'is_seasonal'       => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'sale_price.lt'  => 'Sale price must be less than the regular price.',
            'image.mimes'    => 'Image must be JPG, PNG, or WebP.',
        ];
    }
}
