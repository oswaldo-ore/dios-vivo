<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('categories')->whereNull('category_id')->paginate(10);
        return view('admin.category.index')->with("categories", $categories);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->save();

        return redirect('/admin/category')->with("success", "Agregado con éxito");
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->name = $request->name;

            $category->update();

            return redirect('/admin/category')->with("success", "Actualizado con éxito");
        } catch (\Throwable $th) {
            return redirect('/admin/category')->with("error", "No se pudo actualizar la categoría");
        }
    }

    public function changeState(Category $category){
        try {
            $category->is_enabled = !$category->is_enabled;
            $category->update();
            return response()->json(['message' => 'La categoría fue '.($category->is_enabled ?'activada':'desactivada').' correctamente']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error '.$th->getMessage()],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/category')->with("success", "Eliminado con éxito");
    }
}
