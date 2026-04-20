<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan',
        'akreditasi',
    ];

    /**
     * Relasi: Jurusan memiliki banyak Mahasiswa (One to Many)
     */
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_jurusan', 'id_jurusan');
    }

    /**
     * Relasi: Jurusan memiliki banyak Matakuliah (One to Many)
     */
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'id_jurusan', 'id_jurusan');
    }
}
