<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $recipeId = $this->route('recipe')?->id;

        return [
            'recipe_category_id' => ['nullable', 'exists:recipe_categories,id'],
            'title'              => ['required', 'string', 'max:255'],
            'slug'               => ['nullable', 'string', 'max:255', 'unique:recipes,slug'.($recipeId ? ','.$recipeId : '')],
            'short_description'  => ['nullable', 'string', 'max:500'],
            'description'        => ['nullable', 'string'],
            'prep_time'          => ['nullable', 'string', 'max:50'],
            'cook_time'          => ['nullable', 'string', 'max:50'],
            'total_time'         => ['nullable', 'string', 'max:50'],
            'servings'           => ['nullable', 'integer', 'min:1'],
            'difficulty'         => ['required', 'in:easy,medium,hard'],
            'ingredients'        => ['nullable', 'string'],
            'instructions'       => ['nullable', 'string'],
            'chef_notes'         => ['nullable', 'string'],
            'tips'               => ['nullable', 'string'],
            'video_url'          => ['nullable', 'url', 'max:500'],
            'nutritional_info'   => ['nullable', 'string'],
            'featured_image'     => ['nullable', 'image', 'max:5120'],
            'gallery_images'     => ['nullable', 'array', 'max:10'],
            'gallery_images.*'   => ['image', 'max:5120'],
            'is_featured'        => ['nullable', 'boolean'],
            'seo_title'          => ['nullable', 'string', 'max:255'],
            'seo_description'    => ['nullable', 'string', 'max:320'],
            'seo_keywords'       => ['nullable', 'string', 'max:255'],
            'is_published'       => ['nullable', 'boolean'],
            'sort_order'         => ['nullable', 'integer', 'min:0'],
        ];
    }
}
