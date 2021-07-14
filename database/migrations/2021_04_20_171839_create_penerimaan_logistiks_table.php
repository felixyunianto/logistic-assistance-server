<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanLogistiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_logistiks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_posko')->unsigned();
            $table->string('jenis_kebutuhan', 20);
            $table->text('keterangan');
            $table->integer('jumlah');
            $table->enum('satuan', ['kg', 'liter','dus','unit','buah','ram','lembar','pasang','bungkus','karung','kodi','pak']);
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
        Schema::dropIfExists('penerimaan_logistiks');
    }
}
