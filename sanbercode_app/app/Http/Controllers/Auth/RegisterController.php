<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'email'=>'required|email|unique:users,email',
            'password'=>'min:6|confirmed',
            'name'=>'required',
        ]);
        $request['password'] = bcrypt($request->password);
        $request['role_id'] = Role::where('role','user')->first()->id;
        $user = User::create($request->all());
        $otp = OtpCode::where('user_id',$user->id)->first();
        if(!$otp){
            $new_otp = OtpCode::create([
                'user_id'=>$user->id,
                'otp_code'=>rand(100000,999999),
                'valid_until'=>time()+5
            ]);
            event(new UserRegisteredEvent($new_otp->otp_code,$user->email));
        }else{
            $otp->update([
                'otp_code'=>rand(100000,999999),
                'valid_until'=>time()+5
            ]);
            event(new UserRegisteredEvent($otp->otp_code,$user->email));
        }
        return response()->json(['success'=>true,'pesan'=>'berhasil, silahkan masukkan kode otp']);
    }

    public function checkotp(Request $request){
        $otp = OtpCode::where('otp_code',$request->otp_code)->where('valid_until','<',time())->first();
        $user = $otp->user;
        if($otp){
            $user->update(['email_verified_at',time()]);
            return response()->json(['message'=>'otp anda tepat']);
        }else{
            return response()->json(['message'=>'otp anda kadaluarsa']);
        }
    }
}
