<?php

// database/migrations/..._create_attendances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel interns
            $table->foreignId('intern_id')->constrained('interns')->onDelete('cascade'); 
            
            $table->date('date')->useCurrent(); // Tanggal absensi
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha']);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Memastikan satu intern hanya bisa absen satu kali dalam sehari
            $table->unique(['intern_id', 'date']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};