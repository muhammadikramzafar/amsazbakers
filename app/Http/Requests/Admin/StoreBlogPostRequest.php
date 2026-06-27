<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $postId = $this->route('blogPost')?->id;

        return [
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug'.($postId ? ','.$postId : '')],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'featured_image'   => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            'gallery_images'   => ['nullable', 'array', 'max:12'],
            'gallery_images.*' => ['image', 'max:5120'],
            'status'           => ['required', 'in:draft,published,scheduled'],
            'published_at'     => ['nullable', 'date'],
            'is_featured'      => ['nullable', 'boolean'],
            'seo_title'        => ['nullable', 'string', 'max:255'],
            'seo_description'  => ['nullable', 'string', 'max:320'],
            'seo_keywords'     => ['nullable', 'string', 'max:255'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'is_active'        => ['nullable', 'boolean'],
            'tag_ids'          => ['nullable', 'array'],
            'tag_ids.*'        => ['exists:blog_tags,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('slug') && $this->filled('title')) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }
    }
}
