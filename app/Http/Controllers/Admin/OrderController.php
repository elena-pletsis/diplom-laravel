<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Status;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        $pageTitle = 'Заказы';
        return view('admin.order.index', compact('orders', 'pageTitle'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $pageTitle = 'Подробно заказ #'.$id;
        $orderItems = $order->items;
        $statuses = Status::all();
        //dd($order->status->name);
        $currentStatus = $order->status->name;
        //dd($order->items);
        return view('admin.order.show', compact('order', 'orderItems', 'statuses', 'currentStatus', 'pageTitle'));
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
    public function destroy($id)
    {
        //
    }

    public function userHistory($id)
    {
        $user = User::find($id);
        $pageTitle = 'Подробно история заказов пользователя '.$user->full_name;
        $userOrders = $user->orders;
        //dd($user->orders);
        return view('admin.order.userHistory', compact('user', 'pageTitle', 'userOrders'));
    }

    public function orderStatus(Request $request)
    {
        //dd($request);
        $order = Order::find($request->orderId);
        $order->status_id = $request->statusId;
        $order->save();
    }

    public function orderDetails(Request $request)
    {
        $order = Order::find($request->orderId);
        $orderItems = $order->items;
        //dd($orderItems); 
        return $orderItems;
               
    }
}
