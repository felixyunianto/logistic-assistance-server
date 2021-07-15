<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogistikMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistik_masuks', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kebutuhan', ['sandang','pangan', 'obat obatan', 'paket kematian', 'logistik lainya']);
            $table->text('keterangan');
            $table->integer('jumlah');
            $table->string('pengirim');
            $table->enum('posko_penerima', ['posko Induk Brebes','posko aju 1 Bumiayu','posko aju 2 Sirampog', 'posko aju 3 Bantarkawung','posko aju 4 Kersana']);
            // $table->bigInteger('id_posko')->unsigned();
            $table->enum('status', ['Proses', 'Terima']);
            $table->enum('satuan', ['kg', 'liter','dus','unit','buah','ram','lembar','pasang','bungkus','karung','kodi','pak']);
            $table->date('tanggal');
            $table->text('foto')->nullable();
            $table->text('public_id')->nullable();
            $table->timestamps();

            // $table->foreign('id_posko')->references('id')->on('poskos')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistik_masuks');
    }
}
