<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_telepon',
        'alamat',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'tanggal_konsultasi',
        'waktu_konsultasi',
        'permasalahan',
        'kategori_masalah',
        'dokumen_ktp',
        'dokumen_pendukung',
        'status_step',
        'status_pendaftaran'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_konsultasi' => 'date',
    ];

    // Accessor untuk format tanggal Indonesia
    public function getTanggalLahirFormatAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d/m/Y') : null;
    }

    // Scope untuk filter berdasarkan status
    public function scopeDraft($query)
    {
        return $query->where('status_pendaftaran', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('status_pendaftaran', 'pending');
    }
}