<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistik_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kebutuhan');
            $table->text('keterangan');
            $table->integer('jumlah');
            $table->string('pengirim');
            $table->bigInteger('id_posko')->unsigned();
            $table->enum('status', ['Proses', 'Terima']);
            $table->date('tanggal');
            $table->timestamps();

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
        Schema::dropIfExists('logistik_keluars');
    }
}
