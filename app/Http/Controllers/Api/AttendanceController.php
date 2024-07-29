<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkin(Request $request)
    {
        //validate lat and long
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'address_in' => 'required',
        ]);

        //get current time
        $currentTime = date('H:i:s');

        //save new attendance
        $attendance = new Attendance;
        $attendance->user_id = $request->user()->id;
        $attendance->date = date('Y-m-d');
        $attendance->time_in = $currentTime;
        $attendance->latlon_in = $request->latitude . ',' . $request->longitude;
        $attendance->address_in = $request->address_in;
        $attendance->status = ($currentTime <= '08:20:00' && $currentTime >= '08:00:00') ? 1 : 0;
        $attendance->save();

        return response([
            'message' => 'Checkin success',
            'attendance' => $attendance
        ], 200);
    }


    //checkout
    public function checkout(Request $request)
    {
        //validate lat and long
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'address_out' => 'required',
        ]);

        //get today attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        //check if attendance not found
        if (!$attendance) {
            return response(['message' => 'Checkin first'], 400);
        }

        //save checkout
        $attendance->time_out = date('H:i:s');
        $attendance->latlon_out = $request->latitude . ',' . $request->longitude;
        $attendance->address_out = $request->address_out;
        $attendance->save();

        return response([
            'message' => 'Checkout success',
            'attendance' => $attendance
        ], 200);
    }

    //check is checkedin
    public function isCheckedin(Request $request)
    {
        //get today attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        $isCheckout = $attendance ? $attendance->time_out : false;

        return response([
            'checkedin' => $attendance ? true : false,
            'checkedout' => $isCheckout ? true : false,
        ], 200);
    }

    //index
    public function index(Request $request)
    {
        $date = $request->input('date');
        $currentUser = $request->user();

        $query = Attendance::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->where('user_id', $currentUser->id);

        if ($date) {
            $query->where('date', $date);
        }

        $attendance = $query->get();
        return response([
            'message' => 'success',
            'data' => $attendance
        ], 200);
    }

    //mendapatkan data presensi terlambat peserta berdasarkan pembimbing id
    public function lateAttendance(Request $request)
    {
        $currentUser = $request->user();
        $pembimbingId = $currentUser->id;
        $today = now()->toDateString();

        $attendance = Attendance::with('user:id,name')
            ->whereHas('user', function ($query) use ($pembimbingId) {
                $query->where('pembimbing_id', $pembimbingId);
            })
            ->where('date', $today)
            ->where('status', 0)
            ->get();

        // Mengambil hanya nama pengguna dari hasil query
        $userNames = $attendance->pluck('user.name');

        return response([
            'message' => 'sukses',
            'data' => $userNames
        ], 200);
    }


    //mendapatkan nama peserta yang belum mengambil presensi hari ini
    public function notAbsentToday(Request $request)
    {
        $currentUser = $request->user();
        $pembimbingId = $currentUser->id;
        $today = now()->toDateString();

        // Dapatkan user_ids yang telah melakukan absen hari ini
        $absentUserIds = Attendance::where('date', $today)
            ->where('status', 0)
            ->whereHas('user', function ($query) use ($pembimbingId) {
                $query->where('pembimbing_id', $pembimbingId);
            })
            ->pluck('user_id');

        // Dapatkan data pengguna yang tidak melakukan absen hari ini
        $usersNotAbsentToday = User::where('pembimbing_id', $pembimbingId)
            ->whereNotIn('id', $absentUserIds)
            ->get(['id', 'name']);

        return response([
            'message' => 'sukses',
            'data' => $usersNotAbsentToday
        ], 200);
    }

    //index
    public function getAttendanceById(Request $request, $user_id)
    {
        $date = $request->input('date');

        $query = Attendance::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->where('user_id', $user_id);

        if ($date) {
            $query->where('date', $date);
        }

        $attendance = $query->get();
        return response([
            'message' => 'success',
            'data' => $attendance
        ], 200);
    }
}
