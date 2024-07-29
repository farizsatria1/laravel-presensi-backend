<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    //create
    public function store(Request $request)
    {
        $request->validate([
            'trainer_peserta' => 'nullable|exists:users,id',
            'trainer_pembimbing' => 'nullable|exists:pembimbings,id',
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $progress = new Progress();
        $progress->user_id = $request->user()->id;
        $progress->trainer_peserta = $request->user_id;
        $progress->trainer_pembimbing = $request->pembimbing_id;
        $progress->judul = $request->judul;
        $progress->isi = $request->isi;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/progress', $image->hashName());
            $progress->image = $image->hashName();
        }

        $progress->save();

        return response()->json(['message' => 'Progress created successfully'], 201);
    }
}
