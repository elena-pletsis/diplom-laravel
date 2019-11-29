<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Product;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        $pageTitle = 'Бренды';
        return view('admin.brand.index', compact('brands', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $pageTitle = 'Добавить бренд';
        return view('admin.brand.create', compact('brands', 'pageTitle'));
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
            'title'=>'required|unique:brands,title|max:64'
        ]);
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->slug = $request->slug;        
        $brand->img = $request->filepath;
        $brand->description = $request->description;
        $brand->save();
        return redirect('/admin/brand')->with('message', 'Бренд '. $brand->title . ' добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $choosedBrand = Brand::find($id);
        $products = Product::where('brand_id', '=', $id)->paginate(9);
        //dd($brand);
        return view('web.page.brand', compact('products', 'choosedBrand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        $pageTitle = 'Редактировать бренд';        
        return view('admin.brand.edit', compact('pageTitle', 'brand'));
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
        $brand = Brand::find($id);
        $brand->title = $request->title;
        $brand->slug = $request->slug;        
        $brand->img = $request->filepath;
        $brand->description = $request->description;
        $brand->save();
        return redirect('/admin/brand')->with('message', 'Бренд '. $brand->title . ' обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::find($id)->delete();
        return redirect('/admin/brand');
    }
}
