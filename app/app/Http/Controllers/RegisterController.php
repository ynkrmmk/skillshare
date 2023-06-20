<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     */
    public function create(Request $data)
    {
        if(!empty($data->image)) {
          $file_name = $data->file('image')->getClientOriginalName();
          $data->file('image')->storeAs('public/img' , $file_name);
            $image = 'img/'.$file_name;
        } else {
            $image = 'img/20200502_noimage.jpg';
        }

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'image' => $image,
        ]);
        \Auth::login($user);
        return redirect('/');
    }
}
