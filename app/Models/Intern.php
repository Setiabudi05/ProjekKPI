<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intern extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'student_id', 'school'];

    /**
     * Relasi ke model Attendance (Satu Intern memiliki banyak Attendance)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}