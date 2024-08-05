<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $progress = new Progress();
        $progress->user_id = $request->user()->id;
        $progress->trainer_peserta = $request->trainer_peserta;
        $progress->trainer_pembimbing = $request->trainer_pembimbing;
        $progress->date = date('Y-m-d');
        $progress->judul = $request->judul;
        $progress->isi = $request->isi;
        $progress->status = $request->status ?? '2';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/progress', $image->hashName());
            $progress->image = $image->hashName();
        }

        $progress->save();

        return response()->json(['message' => 'Progress created successfully'], 201);
    }

    //get progress hari ini by user_id
    public function getProgress(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('user_id', $currentUser->id)
            ->where('date', date('Y-m-d'))
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }

    //get progress ditolak by user_id
    public function getProgressDitolak(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('user_id', $currentUser->id)
            ->where('status', '0')
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }

    //get progress revisi by user_id
    public function getProgressRevisi(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('user_id', $currentUser->id)
            ->where('status', '3')
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }

    //get progress revisi by pembimbing_id
    public function getProgressRevisiPembimbing(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('trainer_pembimbing', $currentUser->id)
            ->where('status', '3')
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }

    //get progress recap by user_id
    public function getProgressRecap(Request $request)
    {
        $date = $request->input('date');
        $userId = $request->input('id');
        $currentUser = $request->user();

        // Gunakan user_id yang diberikan jika ada, jika tidak gunakan id user saat ini
        $query = Progress::with(['trainerPembimbing', 'trainerPeserta'])->where('user_id', $userId ? $userId : $currentUser->id);

        if ($date) {
            $query->where('date', $date);
        }

        $progress = $query->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response([
            'message' => 'success',
            'progress' => $progress
        ], 200);
    }

    //update progress
    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $progress = Progress::findOrFail($id);
        $progress->judul = $request->judul;
        $progress->isi = $request->isi;
        $progress->status = '3';

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($progress->image) {
                Storage::delete('public/progress/' . $progress->image);
            }

            $image = $request->file('image');
            $image->storeAs('public/progress', $image->hashName());
            $progress->image = $image->hashName();
        }

        $progress->save();

        return response()->json(['message' => 'Progress updated successfully'], 200);
    }

    //update peserta_approve
    public function updatePesertaApprove(Request $request, $id)
    {
        $request->validate([
            'peserta_approve' => 'required',
        ]);

        $progress = Progress::find($id);
        $progress->peserta_approve = $request->peserta_approve;
        $progress->status = $progress->peserta_approve == 1 ? '1' : '0';
        $progress->save();

        return response()->json(['message' => 'peserta approve updated successfully'], 200);
    }


    //update pembimbing_approve
    public function updatePembimbingApprove(Request $request, $id)
    {
        $request->validate([
            'pembimbing_approve' => 'required',
        ]);

        $progress = Progress::find($id);
        $progress->pembimbing_approve = $request->pembimbing_approve;
        $progress->status = $progress->pembimbing_approve == 1 ? '1' : '0';
        $progress->save();

        return response()->json(['message' => 'pembimbing approve updated successfully'], 200);
    }

    //get progress peserta approve
    public function getProgressPesertaApprove(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('trainer_peserta', $currentUser->id)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->where('peserta_approve', '0')
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }

    //get progress pembimbing approve
    public function getProgressPembimbingApprove(Request $request)
    {
        $currentUser = $request->user();

        $progress = Progress::where('trainer_pembimbing', $currentUser->id)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->where('pembimbing_approve', '0')
            ->where('peserta_approve', '1')
            ->get();

        $progress->each(function ($item) {
            if ($item->trainerPeserta) {
                $item->trainer_name = $item->trainerPeserta->name;
            } elseif ($item->trainerPembimbing) {
                $item->trainer_name = $item->trainerPembimbing->name;
            } else {
                $item->trainer_name = null;
            }
            unset($item->trainerPeserta);
            unset($item->trainerPembimbing);
        });

        return response(['progress' => $progress], 200);
    }
}
