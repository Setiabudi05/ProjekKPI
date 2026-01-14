<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            // Tambahkan kolom yang sekiranya masih kurang
            if (!Schema::hasColumn('interns', 'email')) {
                $table->string('email')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('interns', 'position')) {
                $table->string('position')->nullable()->after('school');
            }

            // Tambahkan status setelah kolom terakhir yang tersedia
            $table->enum('status', ['aktif', 'selesai'])->default('aktif')->after('name');
        });
    }
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
