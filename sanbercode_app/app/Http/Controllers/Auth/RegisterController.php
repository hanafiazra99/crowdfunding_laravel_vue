<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

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
        User::create($request->all());
        return response()->json(['success'=>true,'pesan'=>'berhasil']);
    }
}
