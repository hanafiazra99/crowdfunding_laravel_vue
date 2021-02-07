<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required|min:6'
        ]);

        if(!$token = auth('api')->attempt($request->only('email','password'))){
            return response()->json(['error' => 'Email dan Password Salah'],401);
        }
        $data['token'] = $token;
        $data['user'] = auth()->user();
        return response()->json(compact('data'));
    }

    public function checkToken(){
        return response()->json([
            'response_code' => '00',
            'response_message' => 'Token Valid',
            'data' => true
        ],200);
    }

    public function logout(){
        auth('api')->logout();
        return response([
                        "response_code"=>'00',
                        "message"=>"berhasil logout"

        ],200);
    }
}
