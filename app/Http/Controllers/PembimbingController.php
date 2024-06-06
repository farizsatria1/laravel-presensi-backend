<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        ]);

        Pembimbing::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('$request->password'),
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
        ]);

        $pembimbing->update([
            'name' => $request->name,
            'email' => $request->email,
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
        $pembimbing->delete();
        Alert::success('Sukses', 'Pembimbing berhasil di Hapus');
        return redirect()->route('pembimbings.index');
    }
}
