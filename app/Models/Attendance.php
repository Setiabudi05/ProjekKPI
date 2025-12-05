<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'date',
        'time_in',
        'time_out',
        'status',
        'notes',
    ];

    /**
     * Relasi ke model Intern (Banyak Attendance dimiliki oleh satu Intern)
     */
    public function intern(): BelongsTo
    {
        return $this->belongsTo(Intern::class);
    }
}