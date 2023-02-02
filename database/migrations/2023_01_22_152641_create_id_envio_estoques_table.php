<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdEnvioEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_envio_estoques', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('unidade_id');
            $table->unsignedBigInteger('laboratorio_id');
            $table->string('numDocumento')->unique();

            //ENTREGA SE FOR NECESSARIO
            $table->string('responsavelEnvio')->nullable();
            $table->date('dataEnvio')->nullable();
            $table->date('dataRecebimento')->nullable();
            $table->string('statusItem')->nullable(); //estoque - entregue

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
        Schema::dropIfExists('id_envio_estoques');
    }
}
