<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //index
    public function index()
    {
        $users = User::with('pembimbing')
            ->where('role', 'peserta')
            ->where('name', 'like', '%' . request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }


    //create
    public function create()
    {
        $pembimbingList = Pembimbing::all()->pluck('name', 'id');
        return view('pages.users.create', compact('pembimbingList'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menangani upload gambar
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sekolah' => $request->sekolah,
            'pembimbing_id' => $request->pembimbing_id,
            'image' => $imageName, // Menyimpan nama file gambar ke database
        ]);

        Alert::success('Sukses', 'User berhasil di Tambahkan');
        return redirect()->route('users.index');
    }


    //edit
    public function edit(User $user)
    {
        $pembimbingList = Pembimbing::all()->pluck('name', 'id');
        return view('pages.users.edit', compact('user', 'pembimbingList'));
    }

    //update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::delete('public/images/' . $user->image);
            }

            $image = $request->file('image');
            $imageName = time() . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        } else {
            $imageName = $user->image; // Pertahankan gambar lama jika tidak ada gambar baru yang diupload
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'sekolah' => $request->sekolah,
            'pembimbing_id' => $request->pembimbing_id,
            'image' => $imageName,
        ]);

        //if password filled
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        Alert::success('Sukses', 'Data berhasil di Update');
        return redirect()->route('users.index');
    }

    //destroy
    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::delete('public/images/' . $user->image);
        }
        $user->delete();
        Alert::success('Sukses', 'User berhasil di Hapus');
        return redirect()->route('users.index');
    }
}
