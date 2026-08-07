<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $products = Product::with('category')->orderBy('sort_order')->get();

        $productsJson = $products->map(fn (Product $p) => [
            'name' => $p->name,
            'pack' => $p->pack_size,
            'cat' => $p->category->slug,
            'comp' => $p->composition,
            'grad' => [$p->gradient_start, $p->gradient_end],
            'detail' => $p->description,
        ])->values();

        $catLabels = $categories->pluck('name', 'slug');

        return view('products.index', [
            'categories' => $categories,
            'products' => $products,
            'productsJson' => $productsJson,
            'catLabels' => $catLabels,
        ]);
    }
}
