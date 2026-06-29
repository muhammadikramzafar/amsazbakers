<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $categories = RecipeCategory::active()
            ->withCount(['recipes as published_count' => function ($q) {
                $q->where('is_published', true);
            }])
            ->get();

        $query = Recipe::with('category')->where('is_published', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('short_description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        match ($request->sort) {
            'oldest' => $query->oldest(),
            default  => $query->latest(),
        };

        $recipes = $query->paginate(9)->withQueryString();

        $featuredRecipes = Recipe::with('category')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        $latestRecipes = Recipe::with('category')
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.recipes.index', compact(
            'recipes', 'categories', 'featuredRecipes', 'latestRecipes'
        ));
    }

    public function category(string $slug, Request $request)
    {
        $activeCategory = RecipeCategory::where('slug', $slug)->firstOrFail();

        $categories = RecipeCategory::active()
            ->withCount(['recipes as published_count' => function ($q) {
                $q->where('is_published', true);
            }])
            ->get();

        $query = Recipe::with('category')
            ->where('is_published', true)
            ->where('recipe_category_id', $activeCategory->id);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('short_description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        match ($request->sort) {
            'oldest' => $query->oldest(),
            default  => $query->latest(),
        };

        $recipes = $query->paginate(9)->withQueryString();

        $featuredRecipes = Recipe::with('category')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        $latestRecipes = Recipe::with('category')
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.recipes.index', compact(
            'recipes', 'categories', 'featuredRecipes', 'latestRecipes', 'activeCategory'
        ));
    }

    public function show(Recipe $recipe)
    {
        abort_if(!$recipe->is_published, 404);

        $recipe->load('category');

        $related = Recipe::with('category')
            ->where('recipe_category_id', $recipe->recipe_category_id)
            ->where('id', '!=', $recipe->id)
            ->where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.recipes.show', compact('recipe', 'related'));
    }
}
