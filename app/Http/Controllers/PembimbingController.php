<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PembimbingController extends Controller
{
    //index
    public function index()
    {
        $pembimbings = Pembimbing::where('name', 'like', '%' . request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.pembimbing.index', compact('pembimbings'));
    }

    //create
    public function create()
    {
        return view('pages.pembimbing.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:pembimbings,email',
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

        Pembimbing::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('$request->password'),
            'image' => $imageName,
        ]);

        Alert::success('Sukses', 'Pembimbing berhasil di Tambahkan');
        return redirect()->route('pembimbings.index');
    }

    //edit
    public function edit(Pembimbing $pembimbing)
    {
        return view('pages.pembimbing.edit', compact('pembimbing'));
    }

    //update
    public function update(Request $request, Pembimbing $pembimbing)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($pembimbing->image) {
                Storage::delete('public/images/' . $pembimbing->image);
            }

            $image = $request->file('image');
            $imageName = time() . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        } else {
            $imageName = $pembimbing->image; // Pertahankan gambar lama jika tidak ada gambar baru yang diupload
        }

        $pembimbing->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageName,
        ]);

        //if password filled
        if ($request->password) {
            $pembimbing->update([
                'password' => Hash::make($request->password),
            ]);
        }

        Alert::success('Sukses', 'Pembimbing berhasil di Update');
        return redirect()->route('pembimbings.index');
    }

    //destroy
    public function destroy(Pembimbing $pembimbing)
    {
        if ($pembimbing->image) {
            Storage::delete('public/images/' . $pembimbing->image);
        }
        $pembimbing->delete();
        Alert::success('Sukses', 'Pembimbing berhasil di Hapus');
        return redirect()->route('pembimbings.index');
    }
}
