<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //index
    public function index(){
        //search by name, paginatation 10
        $users = User::where('role', 'peserta')
        ->where('name', 'like', '%' . request('name') . '%')
        ->orderBy('id','desc')
        ->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    //create
    public function create(){
        $pembimbingList = Pembimbing::all()->pluck('name', 'id');
        return view('pages.users.create',compact('pembimbingList'));
    }

    //store
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sekolah' => $request->sekolah,
            'pembimbing_id' => $request->pembimbing_id
        ]);

        Alert::success('Sukses', 'User berhasil di Tambahkan');
        return redirect()->route('users.index');
    }

    //edit
    public function edit(User $user){
        $pembimbingList = Pembimbing::all()->pluck('name', 'id');
        return view('pages.users.edit',compact('user','pembimbingList'));
    }

    //update
    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'sekolah' => $request->sekolah,
            'pembimbing_id' => $request->pembimbing_id
        ]);

        //if password filled
        if($request->password){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        Alert::success('Sukses', 'Data berhasil di Update');
        return redirect()->route('users.index');
    }

    //destroy
    public function destroy(User $user){
        $user->delete();
        Alert::success('Sukses', 'User berhasil di Hapus');
        return redirect()->route('users.index');
    }
}
