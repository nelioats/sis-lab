<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioBemMoveisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_bem_moveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('itemCatalogo_id');
            $table->unsignedBigInteger('unidade_id');
            $table->unsignedBigInteger('laboratorio_id');
            $table->integer('quantidadeItem')->nullable();
            $table->double('valorUndItem')->nullable();
            $table->double('valorTotalItem')->nullable();
            $table->timestamps();

            //CHAVES ESTRANGEIRAS
            $table->foreign('itemCatalogo_id')->references('id')->on('catalogos')->onDelete('CASCADE');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('CASCADE');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorio_bem_moveis');
    }
}
