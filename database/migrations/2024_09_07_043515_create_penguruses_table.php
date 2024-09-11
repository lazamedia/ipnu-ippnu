<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up():void
{
    Schema::create('pengurus', function (Blueprint $table) {
        $table->id();
        $table->string('foto')->nullable();
        $table->string('nama_lengkap');
        $table->string('divisi');
        $table->string('no_wa');
        $table->string('email')->nullable();
        $table->string('pelajar'); // ipnu / ippnu
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};
