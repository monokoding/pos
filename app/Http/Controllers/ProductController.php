<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        $categories = Category::take(20)->get();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'deskripsi'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categories = Product::create([
            'nama'     => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'id_kategori'   => $request->id_kategori,
            'stok'   => $request->stok,
            'harga'   => $request->harga,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $categories
        ]);
    }

    public function show(Product $product)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Product',
            'data'    => $product
        ]);
    }

    public function update(Request $request, Product $category)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update([
            'name'     => $request->name,
            'description'   => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $category
        ]);
    }

    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Berhasil Dihapus!.',
        ]);
    }
}
