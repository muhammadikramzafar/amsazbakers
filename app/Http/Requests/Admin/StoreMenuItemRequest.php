<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $itemId = $this->route('menuItem')?->id;

        return [
            'menu_category_id'  => ['required', 'exists:menu_categories,id'],
            'name'              => ['required', 'string', 'max:200'],
            'slug'              => ['nullable', 'string', 'max:220', 'unique:menu_items,slug'.($itemId ? ','.$itemId : '')],
            'sku'               => ['nullable', 'string', 'max:100', 'unique:menu_items,sku'.($itemId ? ','.$itemId : '')],
            'price'             => ['required', 'numeric', 'min:0'],
            'discount_price'    => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'ingredients'       => ['nullable', 'string'],
            'nutritional_info'  => ['nullable', 'string'],
            'allergens'         => ['nullable', 'string', 'max:500'],
            'calories'          => ['nullable', 'integer', 'min:0'],
            'serving_size'      => ['nullable', 'string', 'max:100'],
            'preparation_time'  => ['nullable', 'string', 'max:50'],
            'featured_image'    => ['nullable', 'image', 'max:5120'],
            'gallery_images'    => ['nullable', 'array', 'max:10'],
            'gallery_images.*'  => ['image', 'max:5120'],
            'is_available'      => ['nullable', 'boolean'],
            'is_featured'       => ['nullable', 'boolean'],
            'is_bestseller'     => ['nullable', 'boolean'],
            'is_chef_recommended' => ['nullable', 'boolean'],
            'is_seasonal'       => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'is_active'         => ['nullable', 'boolean'],
        ];
    }
}
