<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('ketua_pelaksana');
            $table->string('nama_event');
            $table->string('sekretaris');
            $table->string('bendahara');
            $table->string('tempat');
            $table->decimal('anggaran', 15, 2)->nullable();
            $table->string('tanggal');
            $table->text('tamu_undangan')->nullable();
            $table->text('divisi_humas')->nullable();
            $table->text('divisi_acara')->nullable();
            $table->text('divisi_perkap')->nullable();
            $table->text('divisi_dekdok')->nullable();
            $table->text('divisi_konsumsi')->nullable();
            $table->text('keperluan_divisi')->nullable(); // Tambahkan ini
            $table->string('foto')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }
    
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
