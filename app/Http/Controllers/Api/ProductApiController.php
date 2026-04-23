<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request){
        $query = Product::with('category')->where('is_active', true);

        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->search){
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate($query->per_page ?? 12);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function show(Product $product){
        return response()->json([
            'success' => true,
            'data' => $product->load('category'),
        ]);
    }

    public function categories(){
        return response()->json([
            'success' => true,
            'data' => Category::withCount('products')->get(),
        ]);
    }
}
