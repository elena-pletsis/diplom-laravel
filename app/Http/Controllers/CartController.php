<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\NpArea;
use App\NpCity;
use App\NpWarehouse;


class CartController extends Controller
{
    public function addProduct(Request $request)
    {
    	$product = Product::find($request->id);       
    	Cart::add($product, $request->qty);
        //dd($productQuantity);
    	return view('web.product.minicart');
    }

    public function removeAll()
    {
    	Cart::clear();
    	return view('web.product.minicart');
    }
    
    public function removeOne(Request $request)
    {
        $product = Product::find($request->id);
        Cart::removeProduct($product);
        return view('web.product.minicart');
    }

    public function minusOneProduct(Request $request)
    {
        $product = Product::find($request->id);
        Cart::minusProduct($product);
        return view('web.product.minicart');
    }

    public function plusOneProduct(Request $request)
    {
        $product = Product::find($request->id);
        Cart::plusProduct($product);
        return view('web.product.minicart');
    }

    public function checkout()
    {
        $npareas = NpArea::all(); 
        return view('web.product.checkout', compact('npareas'));
    }

    public function getNpCities(Request $request)
    {
       $npcities = NpCity::where('Area', '=', ($request->areaRef))->get();
       return $npcities;
       
    }

    public function getNpWarehouses(Request $request)
    {
       $npwarehouses = NpWarehouse::where('CityRef', '=', ($request->cityRef))->get(); 
       return $npwarehouses;       
    }


    public function buy(Request $request)
    {
        //запись в БД. отправить почту Email. Очистить корзину, Редирект с сообщением
        $request->validate([
                'full_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|regex:/^\+380\d{3}\d{2}\d{2}\d{2}$/'
            ]);
        $npareas = NpArea::where('Ref', '=', ($request->npareas))->get();  
        $npcities = NpCity::where('Ref', '=', ($request->npcities))->get();
        $order = new \App\Order();  //сразу подключим
        $order->user_id = $request->user_id ? $request->user_id : null;
        $order->full_name = $request->full_name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->note = $request->note;
        $order->address = $npareas[0]->Description . " обл., " .$npcities[0]->SettlementTypeDescriptionRu. " ".  $npcities[0]->DescriptionRu . ", " .  $request->npwarehouses;
        //$order->address = $request->address;
        $order->total_sum = session('TotalSum');
        $order->sum_to_pay = session('SumToPay');
        $order->status_id = 1;
        $order->save();
        // после сохранения у order появляется свойство id
        foreach (session('cart') as $product) {
            $item = new \App\OrderItems;
            $item->order_id = $order->id;
            $item->product_id = $product['id']; //ассоциативный массив
            $item->product_title = $product['title'];
            $item->product_price = $product['price'];
            $item->product_qty = $product['qty'];
            $item->save();
            $dbproduct = Product::find($product['id']);
            $dbproduct->quantity = $dbproduct->quantity - $product['qty'];
            $dbproduct->save();
        }
        \Mail::send('emails.orderAdmin', compact('order'), function($message) use ($order){
            $message->to( $order->email)->subject('New order #'.$order->id);
        });
        Cart::clear();
        event(new \App\Events\ChangeOrderEvent($order));
        return redirect('/')->with('message', 'Спасибо! Ваш заказ #'.$order->id);
    }
}
