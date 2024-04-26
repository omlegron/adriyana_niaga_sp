<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masterBarang', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nama')->nullable();
            $table->longText('deskripsi')->nullable();
            
            $table->string('status')->nullable();
            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('masterBarangId')->nullable();
            
            $table->string('orderId')->nullable();

            $table->date('tanggal')->nullable();
            $table->string('total')->comment('LCL, FCL')->nullable();
            
            $table->string('barangPanjang')->nullable();
            $table->string('barangLebar')->nullable();
            $table->string('barangTinggi')->nullable();
            
            $table->string('lokasiJemput')->nullable();
            $table->string('lokasiTujuan')->nullable();
            
            $table->bigInteger('barangJumlah')->nullable();
            
            $table->string('barangKubikasi')->nullable();
            
            
            
            
            $table->longText('deskripsi')->nullable();
            $table->string('status')->nullable();
            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('pesananId')->nullable();
            
            $table->string('jenisPembayaran')->comment('Transfer, Cash')->nullable();

            $table->string('noTransaksi')->nullable();
            $table->date('tanggal')->nullable();
            
            $table->string('jenisBank')->nullable();
            $table->double('biayaAdmin')->nullable();
            $table->double('total')->nullable();
            $table->string('status')->nullable();
            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masterBarang');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('transaksi');
    }
}
