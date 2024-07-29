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
        'judul',
        'isi',
        'image',
        'peserta_approve',
        'pembimbing_approve'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pembimbing(){
        return $this->belongsTo(Pembimbing::class);
    }
}
