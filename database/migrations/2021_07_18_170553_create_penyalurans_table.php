<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyaluransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyalurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penerima');
            $table->enum('jenis_kebutuhan', ['sandang','pangan', 'obat obatan', 'paket kematian', 'logistik lainya']);
            $table->integer('jumlah');
            $table->enum('satuan', ['kg', 'liter','dus','unit','buah','ram','lembar','pasang','bungkus','karung','kodi','pak']);
            $table->enum('status', ['Proses', 'Terima']);
            $table->text('keterangan');
            $table->text('alamat');
            $table->text('foto')->nullable();
            $table->text('public_id')->nullable();
            $table->date('tanggal');
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
        Schema::dropIfExists('penyalurans');
    }
}
