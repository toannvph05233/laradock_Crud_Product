<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function show()
    {
        $products = Product::all();
        return response()->json([
            'data' => $products
        ]);
    }


    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'img' => 'required',
            'price' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'error' => 'Invalid input',
            ], 422);
        } else {
            $product = new Product([
                'name' => $request->name,
                'img' => $request->img,
                'price' => $request->price,
                'description' => $request->description,
            ]);
            $product->save();
            return response()->json([
                'message' => 'Product added successfully'
            ]);
        }
    }

    public function update($id, Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'img' => 'required',
            'price' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'error' => 'Invalid input',
                'details' => $validatedData->errors(),
            ], 400);
        }

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->img = $request->img;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        return response()->json($product);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();

            return response()->json([
                'message' => 'Xóa sản phẩm thành công',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Không tìm thấy sản phẩm',
            ], 404);
        }
    }


}
