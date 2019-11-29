<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUS;
use Mail;


class ContactUSController extends Controller
{
    public function contacts()
        {
            return view('web.page.contacts');
        }

    public function sendContactMail(Request $request)
        {
		    $request->validate([
	            'full_name' => 'required',
		        'email' => 'required|email',
		        'message' => 'required'
	        ]);

	       	ContactUS::create($request->all());

            Mail::send('emails.contact',
		       array(
		           'user_full_name' => $request->full_name,
		           'user_phone' => $request->phone,
		           'user_email' => $request->email,
		           'user_message' => $request->message
		       ), function($message) use ($request)
		   {
		       $message->from($request->email);
		       $message->to('a.pletsis@gmail.com', 'Admin')->subject('New maillist');
		   });

            return redirect()->back()->with('message', 'Спасибо! Ваше сообщение успешно отправлено!');
        }
}
