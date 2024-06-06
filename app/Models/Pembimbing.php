<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pembimbing extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function peserta()
    {
        return $this->hasMany(User::class);
    }
}
