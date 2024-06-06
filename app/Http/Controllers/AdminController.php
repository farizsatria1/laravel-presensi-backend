<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index() {
        $admins = User::where('role', 'admin')
        ->where('name', 'like', '%' . request('name') . '%' )
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('pages.admin.index', compact('admins'));
    }

    //create
    public function create(){
        return view('pages.admin.create');
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
            'role' => $request->role,
        ]);

        Alert::success('Sukses', 'Admin berhasil di Tambahkan');
        return redirect()->route('admins.index');
    }

    //edit
    public function edit(User $admin){
        return view('pages.admin.edit', compact('admin'));
    }

    //update
    public function update(Request $request, User $admin) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        //if password filled
        if($request->password){
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        Alert::success('Sukses', 'Admin berhasil di Update');
        return redirect()->route('admins.index');
    }

    //destroy
    public function destroy(User $admin){
        $admin->delete();
        Alert::success('Sukses', 'Admin berhasil di Hapus');
        return redirect()->route('admins.index');
    }
}
