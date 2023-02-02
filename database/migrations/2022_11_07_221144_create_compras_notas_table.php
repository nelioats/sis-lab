<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_notas', function (Blueprint $table) {
            $table->id();

            $table->string('nota_fiscal_numero')->unique();
            $table->string('empresa');
            $table->date('data_compra')->nullable();
            $table->double('valor_total_nota');
            $table->string('nota_fiscal_path');
            $table->unsignedBigInteger('unidade_id')->nullable();
            $table->unsignedBigInteger('laboratorio_id')->nullable();

            $table->timestamps();

            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras_notas');
    }
}
