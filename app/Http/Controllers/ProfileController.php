<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Review;


class ProfileController extends Controller
{
public function userHistory()
    {
        $user = Auth::user();
        //dd($user);
        $title = 'Detailed order history of user '.$user->full_name;
        $userOrders = $user->orders;
     
        return view('web.profile.userHistory', compact('user', 'title', 'userOrders'));
    }

public function changePassword()
    {
        $user = Auth::user();
        $title = 'Change password of user: '.$user->full_name;
        return view('web.profile.changePassword', compact('user', 'title'));
    }

public function updatePassword(Request $request)
{
		$request->validate([
    		'currentPassword' => 'required',
    	    'newPassword' => 'required',
    	    'passwordConfirmation' => 'required|same:newPassword',
        ]);

		$user = Auth::user();
		$currentPassword = $request->currentPassword;
		$newPassword = $request->newPassword;

		if( !Hash::check($currentPassword, $user->password)){
			echo 'Current password does not match the database password'; //when user enter wrong password at current password
		} else {
			$user->fill(['password' => Hash::make($newPassword)])->save();  //updating password in user table
			return redirect()->to('/')->with('message', 'Ваш пароль успешно изменён!');		
		}
	} 

	public function profilePage()
	{
		return view('layouts.profile');
	}

	public function index()
    {
        $user = Auth::user();
        $pageTitle = 'Profile details';
        return view('web.profile.details', compact('user', 'pageTitle'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email'=>'sometimes|email|unique:users,email',
            'password'=>'sometimes|nullable|min:8',
            'phone' => 'sometimes|regex:/^\+380\d{3}\d{2}\d{2}\d{2}$/'
        ]);
        //dd($request->full_name);
        $user = Auth::user();
        //$arr = [explode(' ', $request->full_name)];
        $arr = (explode(' ', $request->full_name));
        //dd($arr);
        $user->first_name = $arr[0];
        $user->last_name = $arr[1];
        $user->email = $request->email;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->club_member = $request->has('club_member') ? 1 : 0;
        //dd($user);
        $user->save();//чтобы у user появилось свойство id. нужно сохранить в БД
        return redirect('/profile/profile-details')->with('message', 'Данные ' . $user->full_name . ' обновлены!');
    }

    public function userReview()
    {
        $user = Auth::user();
        $reviews = Review::where('user_id', '=', $user->id)->paginate(12);
      
        if($reviews->count() > 0){
            return view('web.profile.reviews', compact('user', 'reviews'));
        } else {
            return view('web.profile')->with('message', 'Пока нет отзывов!');
        }       
    }

    
}
