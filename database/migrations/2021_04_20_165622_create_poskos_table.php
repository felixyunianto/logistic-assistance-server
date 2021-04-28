<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoskosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poskos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah_pengungsi');
            $table->char('kontak_hp',14);
            $table->text('lokasi');
            $table->decimal('longitude', $precision = 9, $scale = 6);
            $table->decimal('latitude', $precision = 8, $scale = 6);
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('id_posko')->references('id')->on('poskos')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poskos');
    }
}
