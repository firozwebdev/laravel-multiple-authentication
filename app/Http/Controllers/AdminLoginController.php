<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm(){
        return view('admin-auth.login');
    }

    public function login(Request $request){
       //validate the form data
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        //Attempt to log the user in
        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            //if successfull , then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));

        }

        return redirect()->back()->withInput($request->only('email','remember'));

    }
}
