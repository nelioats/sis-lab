<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioInsumosEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_insumos_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprasnota_id')->nullable();
            $table->unsignedBigInteger('unidade_id');
            $table->unsignedBigInteger('laboratorio_id');
            $table->unsignedBigInteger('itemCatalogo_id');
            $table->string('codCompraItem')->nullable();
            $table->integer('quantidadeItem');
            $table->double('valorUndItem')->nullable();
            $table->double('valorTotalItem')->nullable();

            //ENTREGA SE FOR NECESSARIO
            $table->string('emitenteItem')->nullable();
            $table->date('dataEnvioItem')->nullable();
            $table->string('statusItem')->nullable(); //estoque - entregue

            $table->timestamps();


            //CHAVES ESTRANGEIRAS
            $table->foreign('comprasnota_id')->references('id')->on('compras_notas')->onDelete('CASCADE');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');
            $table->foreign('itemCatalogo_id')->references('id')->on('catalogos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorio_insumos_equipamentos');
    }
}
