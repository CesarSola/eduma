<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback(){
        $user = Socialite::driver('google')->user();

        $findUser = User::where('google_id',$user->id)->first();
        if($findUser){
            Auth::login($findUser);
            return redirect()->intended('/');
        }else{
            $user = User::updateOrCreate([
                'email' => $user->email,
            ], [
                'name' => $user->name,
                'google_id' => $user->id,
                'password' => encrypt('12345678'),

            ]);

            Auth::login($user);


        }
        return redirect()->intended('dashboard');
    }


}
