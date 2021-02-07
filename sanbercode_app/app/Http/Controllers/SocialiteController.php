<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Exception as GlobalException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class SocialiteController extends Controller
{
    public function redirectProvider($provider){
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return response()->json([
            'url' => $url
        ]);
    }

    public function handleProviderCallback($provider){
        try {

            $social_user = Socialite::driver($provider)->stateless()->user();
            
            if(!$social_user){
                return response()->json([
                    'response_code'=> '01',
                    'response_message' => 'Login Failed'
                ],401);
            }
            $user = User::where('email',$social_user->email)->first();

            if(!$user){
                try {
                    $user = User::create([
                        'email' => $social_user->email,
                        'name' => $social_user->name,
                        'email_verified_at' => Carbon::now(),
                        'role_id' => Role::where('role','user')->first()->id
                    ]);
                } catch (\Throwable $th) {
                    return $th;
                }
                
            }
            $data['user'] = $user;
            $data['token'] = auth()->login($user);
            return response()->json([
                'response_code'=> '00',
                'data' => $data
            ],200);
        }catch (GlobalException $e) {
            return response()->json($e);
        }
        
    }


}
