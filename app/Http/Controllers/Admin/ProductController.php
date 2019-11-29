<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Review;
use App\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get(); //альтернатива, чтоб выводились последние вначале
        $pageTitle = 'Товары';
        return view('admin.product.index', compact('products', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Добавление товара';
        return view('admin.product.create', compact('pageTitle'));
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
            'title' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'

        ]);
        $product = new Product();
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description; 
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->package = is_null($request->package) ? 'шт.' : $request->package;
        $product->quantity = is_null($request->quantity) ? 0 : $request->quantity;
        $product->img = $request->filepath;
        $product->status = $request->has('status') ? 1 : 0;
        $product->hit = $request->has('hit') ? 1 : 0;
        $product->category_id = ($request->parentId);
        $product->brand_id = ($request->brand == 0)  ? 20 : $request->brand;
        //dd($product);       
        $product->save();
        return redirect('/admin/product')->with('message', 'Товар '. $product->title . ' добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Редактирование товара';
        $product = Product::find($id);
        return view('admin.product.edit', compact('pageTitle', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // https://laracasts.com/discuss/channels/laravel/how-to-pass-checkbox-value-0-if-not-checked-and-1-if-checked
    public function update(Request $request, $id)
    {        
        //dd($request);
         $request->validate([
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|numeric'

        ]);
        $product = Product::find($id);
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description; 
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->package = $request->package;
        $product->quantity = $request->quantity;
        $product->status = $request->has('status') ? 1 : 0;
        $product->img = $request->filepath;
        $product->hit = $request->has('hit') ? 1 : 0;
        $product->category_id = ($request->parentId);
        $product->brand_id = ($request->brand);
        $product->save();
        return redirect('/admin/product')->with('message', 'Товар '. $product->title . ' обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     Product::find($id)->delete();
    //     return redirect('/admin/product');
    // }

    public function editHit(Request $request)
    {
        //dd($request);
        $product = Product::find($request->id);
        $product->hit = $product->hit ? 0 : 1;
        echo $product->save();
    }

    public function editStatus(Request $request)
    {
        $product = Product::find($request->id);
        $product->status = $product->status ? 0 : 1;
        echo $product->save();
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->id);
        echo $product->save();
        Product::find($request->id)->delete();
        
    }

    public function updatePrice(Request $request)
    {
        echo $request->id;
        $product = Product::find($request->id);
        $product->price = $request->newPrice;
        $product->save();       
    }

    public function search(Request $request)
    {
        $s = $request->s;
        $searchProducts = Product::where('title', 'LIKE', '%'.$s.'%')->orWhere('description', 'LIKE', '[[:<:]]'.$s.'[[:>:]]')->paginate(9);
        return view('web.product.search', compact('searchProducts', 's'));
    }

    public function showProductReview($id)
    {
        $product = Product::find($id);
        $reviews = Review::where('product_id', '=', $id)->paginate(12);
        $pageTitle = 'Все отзывы по товару - ';
        return view('admin.review.productReviews', compact('product', 'reviews', 'pageTitle'));  
    } 

    public function filteredProducts(Request $request)
    {
        //dd($request);
        $categories = $request->category;
        $brands = $request->brand;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $filteredProducts = Product::filter()->paginate(9);
        $titleCategory = Category::find($request->titleCategory);
        return view('web.page.filtered', compact('filteredProducts', 'titleCategory', 'price_from', 'price_to', 'categories', 'brands'));
    }

}



