<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $pageTitle = 'Категории';
        return view('admin.category.index', compact('categories', 'pageTitle'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $pageTitle = 'Добавить категорию';
        return view('admin.category.create', compact('categories', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:64'
        ]);
        $category = new Category();
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->parent_id = ($request->parentId) == 0 ? null : ($request->parentId);
        $category->img = $request->filepath;
        $category->save();        
        return redirect('/admin/category')->with('message', 'Категория '. $category->title . ' добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $choosedCategory = Category::find($id);
        $titleCategory = Category::find($id)->parent;
        $products = Product::where('category_id', '=', $id)->paginate(9);
        //dd($choosedCategory);
        return view('web.page.category', compact('products', 'titleCategory', 'choosedCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $pageTitle = 'Редактировать категорию';
        $category = Category::find($id);
        return view('admin.category.edit', compact('pageTitle', 'category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'sometimes|max:64'
        ]);
        $category = Category::find($id);
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->parent_id = $request->parentId==0?null:$request->parentId;
        $category->img = $request->filepath;
        $category->save();
        return redirect('/admin/category')->with('message', 'Категория  '. $category->title . ' обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect('/admin/category');
    }

    public function titleCategories(Request $request)
    {
        //dd($request);
        $mainCategory = Category::find($request->categoryId);
        $titleCategories = $mainCategory->children;
        //dd($titleCategories); 
        return $titleCategories;
               
    }

    public function subCategories(Request $request)
    {
        //dd($request);
        $titleCategory = Category::find($request->categoryId);
        $subCategories = $mainCategory->children;
        //dd($titleCategories); 
        return $subCategories;
               
    }
}
