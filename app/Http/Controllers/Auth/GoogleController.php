<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
class GoogleController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        $user       =   Socialite::driver('google')->user(); // thông tin google trả về 
 		$google     =   User::where('email',$user->email)->where('provider','google')->first(); //xác nhận thông tin tài khoản đã có hay chưa 
 		
        if ($google) {
            if ($google->status == 1) {
                Auth::login($google);
                return redirect('/');
            }
            return redirect('login')->with('loginFail','Tài khoản của bạn đã bị khóa');
 		}
 		else{
            $temp = User::create([
                'name'      =>  $user->name,
                'email'     =>  $user->email,
                'password'  =>  bcrypt(str_random(6)),
                'provider'  =>  'google',
                'avatar'    =>  $user->avatar,
                'lever'     =>  2,
                'status'    =>  1,
            ]);
            Auth::login($temp);
 			return redirect('/');;
 		}
        
    }
}
