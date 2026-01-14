<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika nama tabel sudah jamak 'attendances')
     */
    protected $table = 'attendances';

    /**
     * Kolom yang dapat diisi secara massal.
     * Sesuaikan 'check_in' dan 'check_out' agar sinkron dengan file Migration.
     */
    protected $fillable = [
        'intern_id',
        'date',
        'check_in',  // Mengganti time_in agar sesuai standar migration sebelumnya
        'check_out', // Mengganti time_out agar sesuai standar migration sebelumnya
        'status',
        'notes',
    ];

    /**
     * Relasi ke model Intern (Banyak Attendance dimiliki oleh satu Intern)
     * Ini memungkinkan kita memanggil $attendance->intern->name di laporan.
     */
    public function intern(): BelongsTo
    {
        return $this->belongsTo(Intern::class, 'intern_id');
    }
}