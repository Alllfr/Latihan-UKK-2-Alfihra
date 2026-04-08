<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_buku',
        'judul_buku',
        'pengarang',
        'kategori',
        'penerbit',
        'tanggal_register',
        'stok',
        'foto',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }

    public function getRouteKeyName()
{
    return 'id_buku';
}
}