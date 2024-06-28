<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    //login
    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('role', 'peserta')
        ->with(['pembimbing' => function ($query) {
            $query->select('id', 'name');
        }])
        ->where('email', $loginData['email'])->first();

        //check user
        if(!$user){
            return response(['message' => 'Invalid credentials'], 401);
        }

        //check password
        if(!Hash::check($loginData['password'], $user->password)){
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
       

        return response(['user' => $user, 'token' => $token],200);
    }

    //logout
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged Out'], 200);
    }

    //update image profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = $request->user();
        $image = $request->file('image');

        //save image
        $image->storeAs('public/images', $image->hashName());
        $user->image = $image->hashName();
        $user->save();

        return response([
            'message' => 'Profile updated',
            'user' => $user,
        ], 200);
    }
}
