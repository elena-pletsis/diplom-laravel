<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discount;


class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = Discount::all();
        $pageTitle = 'Возможные скидки';
        return view('admin.discount.index', compact('discount', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $discount = Discount::all();
        $pageTitle = 'Добавить скидку';
        return view('admin.discount.create', compact('discount', 'pageTitle'));
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
            'name'=>'required',
            'discount'=>'required|numeric'
        ]);
        $discount = new Discount();
        $discount->name = $request->name;
        $discount->discount = $request->discount;
        
        $discount->save();//чтобы у user появилось свойство id. нужно сохранить в БД
        return redirect('/admin/discount')->with('message', 'Скидка ' . $discount->name . ' добавлена!');  //with() функция - это однаразовая сессия
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
        $pageTitle = 'Редактирование данных';
        $discount = Discount::find($id);
        return view('admin.discount.edit', compact('pageTitle', 'discount'));
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
            'discount'=>'sometimes|numeric'
        ]);
        $discount = Discount::find($id);
        $discount->name = $request->name;
        $discount->discount = $request->discount;
        $discount->save();
        return redirect('/admin/discount')->with('message', 'Скидки ' . $discount->name . ' обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discount::find($id)->delete();
        return redirect('/admin/discount');
    }
}
