<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvioEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_estoques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_envio');
            $table->unsignedBigInteger('itemCatalogo_id');
            $table->string('itemNome');
            $table->unsignedBigInteger('comprasnota_id')->nullable();
            $table->string('codCompraItem')->nullable();
            $table->integer('quantidadeItem');
            $table->double('valorUndItem')->nullable();
            $table->double('valorTotalItem')->nullable();

            //ENTREGA SE FOR NECESSARIO
            $table->string('responsavelEnvio')->nullable();
            $table->date('dataEnvio')->nullable();
            $table->string('statusItem')->nullable(); //estoque - entregue

            $table->timestamps();


            //CHAVES ESTRANGEIRAS
            $table->foreign('id_envio')->references('id')->on('id_envio_estoques')->onDelete('CASCADE');
            // $table->foreign('unidade_id')->references('id')->on('unidades');
            // $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
            // $table->foreign('itemCatalogo_id')->references('id')->on('catalogos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envio_estoques');
    }
}
