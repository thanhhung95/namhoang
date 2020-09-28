<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Support\Facades\Auth;
class FacebookController extends Controller
{
      public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $facebook = User::where('email',$user->email)->where('provider','facebook')->first();

        if ($facebook) {
            if ($facebook->status == 1) {
                Auth::login($facebook);
                return redirect('/');
            }
            return redirect('login')->with('loginFail','Tài khoản của bạn đã bị khóa');
        }
        else{
            $temp = User::create([
                'name'      =>  $user->name,
                'email'     =>  $user->email,
                'password'  =>  bcrypt(str_random(6)),
                'provider'  =>  'facebook',
                'avatar'    =>  $user->avatar,
                'lever'     =>  2,
                'status'    =>  1,
            ]);
            Auth::login($temp);
            return redirect('/');
        }
    }
}
