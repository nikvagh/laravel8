<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class GoogleSocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return FacadesSocialite::driver('google')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
     
            $user = FacadesSocialite::driver('google')->user();
      
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
      
                Auth::login($finduser);
                return redirect('/home');
      
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'password' => encrypt('my-google')
                ]);
     
                Auth::login($newUser);
                return redirect('/home');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
