<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.presensi.index', compact('attendances'));
    }

    public function cetakPresensi($userId)
    {
        // Ambil data presensi berdasarkan user ID
        $presensi = Attendance::where('user_id', $userId)
            ->with('user') // pastikan untuk load relationship user
            ->orderBy('created_at', 'asc')
            ->get();

        // Jika data presensi kosong, kembalikan dengan pesan error
        if ($presensi->isEmpty()) {
            return view('pages.cetak.notfound.404-presensi');
        }

        // Kembalikan view dengan data presensi
        return view('pages.cetak.cetak-presensi', compact('presensi'));
    }
}
