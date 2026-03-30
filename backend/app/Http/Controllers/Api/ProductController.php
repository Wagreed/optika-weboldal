<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('is_active', true)
            ->with(['images', 'categories']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('brand', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('type')) {
            match($request->type) {
                'sunglasses' => $query->where('is_sunglasses', true),
                'prescription' => $query->where('is_prescription', true),
                default => null,
            };
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        match($request->get('sort', 'newest')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12);
        $products->getCollection()->transform(fn($p) => $this->appendImageUrls($p));

        return response()->json($products);
    }

    public function featured()
    {
        $products = Product::where('is_active', true)
            ->where('featured', true)
            ->with('images')
            ->get();

        return response()->json([
            'products' => $products->map(fn($p) => $this->appendImageUrls($p)),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'categories'])
            ->firstOrFail();

        return response()->json(['product' => $this->appendImageUrls($product)]);
    }

    private function appendImageUrls(Product $product): Product
    {
        $product->images->transform(function ($image) {
            $image->url = Storage::disk('public')->url($image->image_path);
            return $image;
        });

        $primary = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
        $product->primary_image_url = $primary?->url;

        return $product;
    }
}
