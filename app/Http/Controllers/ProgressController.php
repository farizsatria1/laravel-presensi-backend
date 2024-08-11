<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query dasar untuk mengambil data Progress beserta relasi user dan pembimbing
        $query = Progress::with(['user', 'trainerPembimbing'])
            ->orderBy('id', 'desc');

        // Memeriksa apakah ada input pencarian nama user
        if ($request->has('name') && $request->name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // Menjalankan query dengan pagination
        $progresses = $query->paginate(10);

        // Mengirimkan data ke view dengan nama variabel $progresses
        return view('pages.progress.index', compact('progresses'));
    }

    public function cetakProgress($userId)
    {
        // Ambil data progress berdasarkan user ID
        $progress = Progress::where('user_id', $userId)
            ->with('user') // pastikan untuk load relationship user
            ->orderBy('created_at', 'asc')
            ->get();

        // Jika data progress kosong, kembalikan dengan pesan error
        if ($progress->isEmpty()) {
            return view('pages.cetak.notfound.404-progress');
        }

        // Kembalikan view dengan data progress
        return view('pages.cetak.cetak-progress', compact('progress'));
    }
}
