<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intern extends Model
{
    use HasFactory;

    /**
     * Pastikan semua kolom yang digunakan di Controller dan Migration 
     * terdaftar di dalam $fillable agar bisa disimpan ke database.
     */
    protected $fillable = [
        'name', 
        'email', 
        'student_id', 
        'school', 
        'major', 
        'period', 
        'position', 
        'status'
    ];

    /**
     * Relasi ke model Attendance (Satu Intern memiliki banyak Attendance)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}