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
            return response(null,401);
        }
        return response()->json(compact('token'));
    }

    public function logout(){
        auth('api')->logout();
        return response("berhasil logout");
    }
}
