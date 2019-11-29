<?php

namespace App;

use Session;
use App\Discount;


class Cart
{
    static public function add($product, $qty)
    {
        // dd($product);
    	if(Session::get("cart.product_{$product->id}")){
    		$oldQty = Session::get("cart.product_{$product->id}.qty");
    		Session::put("cart.product_{$product->id}.qty", $qty + $oldQty);
    	}
    	else{
	    	Session::put("cart.product_{$product->id}.title", $product->title);
            Session::put("cart.product_{$product->id}.dbquantity", $product->quantity);
	    	// вложенность массива, чтобы обратиться к name указывается через (.), 1 параметр куда записываем второй - что записываем
	    	Session::put("cart.product_{$product->id}.price", $product->price);
	    	Session::put("cart.product_{$product->id}.img", $product->img);
	    	Session::put("cart.product_{$product->id}.id", $product->id);
	    	Session::put("cart.product_{$product->id}.qty", $qty);
    	}
        // dd(Session::get("cart.product_{$product->id}"));
    	self::setTotalSum();
        self::setTotalQty();
    	
    }

//изменение количества продуктов в корзине
	static public function minusProduct($product)
    {
        // dd(Session::get("cart.product_{$product->id}"));
        if(Session::get("cart.product_{$product->id}.qty") > 1){
            $oldQty = Session::get("cart.product_{$product->id}.qty");
            Session::put("cart.product_{$product->id}.qty", $oldQty - 1);  
        }
    	self::setTotalSum();
        self::setTotalQty();
    }

    static public function plusProduct($product)
    {
        // dd(Session::get("cart.product_{$product->id}"));
        if(Session::get("cart.product_{$product->id}.qty") >= 1){
            $oldQty = Session::get("cart.product_{$product->id}.qty");
            Session::put("cart.product_{$product->id}.qty", $oldQty + 1);

        }        
        self::setTotalSum();
        self::setTotalQty();
    }

// удаление из корзины полностью одного продукта
    static public function removeProduct($product)
    {
        // dd(Session::get("cart.product_{$product->id}"));
        if(Session::get("cart.product_{$product->id}.qty")){
            Session::forget("cart.product_{$product->id}");   
        }
        self::setTotalSum();
        self::setTotalQty();
    }

	static public function clear()
    {
    	Session::forget('cart');
    	Session::forget('TotalSum');
        Session::forget('TotalQty');
    }

// будем вызывать только в этом классе
    static private function setTotalSum()
    {
    	//проходим по массиву и пересчитываем сумму
        $sum = 0;
    	foreach(Session::get('cart') as $product){
    		$sum += $product['qty'] * $product['price'];
    	}

        $sum_to_pay = $sum;
        
        if ($sum >= 1000){
            $discPercent = Discount::find('2')->percent;
            //dd($discPercent);
            $sum_to_pay = $sum*((100-$discPercent)/100);             
        } elseif (\Auth::user()){
            $user = \Auth::user();
            if ($user->club_member == 1)  {
                $discPercent = Discount::find('3')->percent;
                //dd($discPercent);
                $sum_to_pay = $sum*((100-$discPercent)/100); 
            }            
            elseif (count($user->orders) == 0 And $sum <= 1000) {

                $discPercent = Discount::find('1')->percent;
                //dd($discPercent);
                $sum_to_pay = $sum*((100-$discPercent)/100); 
            }            
        }
       
        $discount = isset($discPercent) ? $discPercent : 0;        
        Session::put('Discount', round($discount, 2));
        Session::put('TotalSum', round($sum, 2));
        Session::put('SumToPay', round($sum_to_pay, 2));   

    }

    static public function setTotalQty()
        {
            //проходим по массиву и пересчитываем сумму
            $TotalQty = 0;
            foreach(Session::get('cart') as $product){
                $TotalQty += $product['qty'];
            }       

            Session::put('TotalQty', $TotalQty);  

        }



}
