<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use App\Review;
use App\RelatedProduct;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
        {
            $hits = Product::status()->hit()->withImg()->latest()->take(12)->get();            
            $brands = Brand::withImg()->get();
            //dd($brands);
            return view('web.page.home', compact('hits', 'brands'));
        }
    public function showProduct($slug)    
        {
            $product = Product::where('slug', '=', $slug)->first();  //first() - вернет не коллекцию (как get и paginate), а перевый эл-т
            $titleCategory = Category::find($product->category_id)->parent;
            $relatedProducts = $product->relatedProducts->take(3);
            //dd($titleCategory);
            $productReview = Review::where('product_id', '=', $product->id)->get();
            return view('web.product.show', compact('product', 'productReview', 'relatedProducts', 'titleCategory'));
        }
    
    public function myHistory()
        {
            $user = \Auth::user();
            //dd($user->orders);
            $pageTitle = 'Detailed order history of user '.$user->name;
            $userOrders = $user->orders;         
            return view('myHistory', compact('user', 'pageTitle', 'userOrders'));
        }

    public function deliveryDetails()
        {
            return view('web.page.deliveryDetails');
        }

}
