<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trainer_pembimbing',
        'trainer_peserta',
        'date',
        'judul',
        'isi',
        'image',
        'peserta_approve',
        'pembimbing_approve',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trainerPembimbing(){
        return $this->belongsTo(Pembimbing::class, 'trainer_pembimbing');
    }

    public function trainerPeserta(){
        return $this->belongsTo(User::class, 'trainer_peserta');
    }
}
