<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Wishlist;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
   //Add __construct to your controller to access only logged users to make wish list:
    public function __construct() 
    {
        $this->middleware(['auth']);
    }


    public function index()
    {
        $user = Auth::user();
        $wishlist = Wishlist::where("user_id", "=", $user->id)->orderby('id', 'desc')->paginate(12);
      return view('web.profile.wishlist', compact('user', 'wishlist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
        'user_id'=>'required',
        'product_id' =>'required',
        ));

        $status = Wishlist::where('user_id', Auth::user()->id)
        ->where('product_id', $request->product_id)
        ->first();

        if(isset($status->user_id) and isset($request->product_id))
           {
                //dd($status);
                $wishlist = Wishlist::findOrFail($status->id);
                $wishlist->delete();
                return 'deleted';
               

           } else {
               $wishlist = new Wishlist;
               $wishlist->user_id = $request->user_id;
               $wishlist->product_id = $request->product_id;
               $wishlist->save();
               return 'added';
              

              // return redirect()->back()->with('flash_message', 'Item, '. $wishlist->product->title.' Added to your wishlist.');
           }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteWishProduct(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)
        ->where('product_id', $request->product_id)
        ->first();
        $wishlist->delete();
        return redirect()->route('wishlist.index')->with('flash_message', 'Товар удален!');
    }
}
