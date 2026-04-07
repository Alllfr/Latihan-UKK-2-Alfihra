<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}