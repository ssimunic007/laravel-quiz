<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        //dd(User::all());
        $is_valid = Auth::attempt(['email' => $email, 'password' => $password]);
        
        if($is_valid) {
            $user = User::where('email', '=', $email)->get()->first();
            //Auth::login($user);
            return $user;
        }

        $error = [
            'error' => 'Invalid credentials!'
        ];

        return json_encode($error);
    }

    public function register(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;

        try{
            return User::create([
                'name' => $name,
                'password' => $password,
                'email' => $email
            ]);
        }
        catch(\Exception $e) {
            $error = [
                'error' => 'Your email is already in use.'
            ];

            return json_encode($error);
        }
    }
}
