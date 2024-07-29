<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PembimbingController extends Controller
{
    //login
    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $pembimbing = Pembimbing::where('email', $loginData['email'])->first();

        //check pembimbing
        if(!$pembimbing){
            return response(['message' => 'Invalid credentials'], 401);
        }

        //check password
        if(!Hash::check($loginData['password'], $pembimbing->password)){
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $pembimbing->createToken('auth_token')->plainTextToken;

        return response(['pembimbing' => $pembimbing, 'token' => $token],200);
    }

    //logout
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logged Out'], 200);
    }

    //index
    public function index() {
        $pembimbing = Pembimbing::get();
        return response(['pembimbing' => $pembimbing], 200);
    }
}
