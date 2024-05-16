<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categories = Category::create([
            'name'     => $request->name,
            'description'   => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $categories
        ]);
    }

    public function show(Category $category)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Category',
            'data'    => $category
        ]);
    }

    public function update(Request $request, Category $category)
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
        Category::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Berhasil Dihapus!.',
        ]);
    }
}
