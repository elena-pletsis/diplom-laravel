<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Review;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $pageTitle = 'Пользователи';
        return view('admin.users.index', compact('users', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $pageTitle = 'Добавить пользователя';
        return view('admin.users.create', compact('roles', 'pageTitle'));
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
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);
        $user = new User();
        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password =\Hash::make($request->password);//Hash - зашифровывает пароль или можно подключить вверху use Hash
        $user->club_member = $request->club_member;   
        $user->save();//чтобы у user появилось свойство id. нужно сохранить в БД
        $user->roles()->sync($request->roles);    //Many To Many Relationships/Syncing Associations https://laravel.com/docs/5.8/eloquent-relationships#updating-many-to-many-relationships
        return redirect('/admin/users')->with('message', 'Пользователь ' . $user->full_name . ' добавлен!');  //with() функция - это однаразовая сессия
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
        $pageTitle = 'Редактирование данных пользователя';
        $userRoles = User::find($id)->roles()->get();
        $roles = Role::all();
        $user = User::find($id);
        // dd($user->toArray());
        return view('admin.users.edit', compact('pageTitle', 'userRoles', 'roles', 'user'));
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
            'email'=>'sometimes|email|unique:users,email,'.$id,
            'password'=>'sometimes|nullable|min:8',  
            // sometimes запускать проверки поля, только если оно есть во входном массиве
        ]);
        $user = User::find($id);
        $user->first_name = $request->fname;
        $user->last_name = $request->lname;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->club_member = $request->has('club_member') ? 1 : 0;
        $new_password = $request->new_password;

        if($new_password){
            $user->password =\Hash::make($new_password);
        }
        $user->save();//чтобы у user появилось свойство id. нужно сохранить в БД
        $user->roles()->sync($request->roles);
        return redirect('/admin/users')->with('message', 'Пользователь ' . $user->full_name . ' обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/admin/users');
    }
    
    public function editClubMember(Request $request)
    {
        //echo $request->id;
        $user = User::find($request->id);
        $user->club_member = $user->club_member == 1 ? 0 : 1;
        echo $user->save();
    }

    public function userReviews($id)
    {
        $user = User::find($id);
        $reviews = Review::where('user_id', '=', $id)->paginate(12);
        $pageTitle = 'All reviews of user '.$user->full_name;
        return view('admin.review.userReviews', compact('user', 'reviews', 'pageTitle'));  
    } 

}
