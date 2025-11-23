<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'sku'      => 'required|string|max:255|unique:products',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0'
        ]);

        $product = Product::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name'     => 'string|max:255',
            'sku'      => 'string|max:255|unique:products,sku,' . $id,
            'quantity' => 'integer|min:0',
            'price'    => 'numeric|min:0'
        ]);

        $product->update($validated);

        // Refresh model untuk mendapatkan data terbaru dari database
        $product->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }
}
