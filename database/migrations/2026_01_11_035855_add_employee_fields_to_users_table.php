<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->unique()->nullable()->after('name');
            $table->string('jabatan')->nullable()->after('nip');
            $table->enum('jenis_pegawai', ['ASN', 'NON ASN', 'PPPK'])->nullable()->after('jabatan');
            $table->string('username')->unique()->nullable()->after('email');
            $table->integer('jumlah_cuti')->default(12)->after('password');
            $table->enum('role', ['admin', 'pegawai'])->default('pegawai')->after('jumlah_cuti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'jabatan', 'jenis_pegawai', 'username', 'jumlah_cuti', 'role']);
        });
    }
};
