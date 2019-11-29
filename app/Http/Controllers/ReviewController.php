<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\Product;

class ReviewController extends Controller
{
   public function __construct() 
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $reviews = Review::all();
        $pageTitle = 'Reviews';
        return view('admin.review.index', compact('reviews', 'pageTitle'));
    }

    public function addReview(Request $request)
    {
       $validatedData = $request->validate([
            'review_text' => 'required|min:5|max:2000',
        ]);
       $review = new Review();
       $review->user_name = Auth::user()->full_name; 
       $review->user_id = Auth::user()->id; 
       // dd(Auth::user()->full_name);     
       $review->review_text = $request->review_text;
       $review->product_id = $request->productId;

       $review->save();

       return redirect()->back()->with('message', 'Отзыв добавлен, спасибо!');
    }  

}
