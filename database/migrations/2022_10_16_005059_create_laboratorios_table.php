<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidade_id');
            $table->string('prefixo')->nullable();
            $table->string('base');
            $table->unsignedBigInteger('componente_id');
            $table->string('status')->nullable();
            $table->date('data_prevista_entrega')->nullable();
            $table->date('data_entrega')->nullable();
            $table->string('fornecedor')->nullable();
            $table->string('aquisicao')->nullable();
            $table->string('investimento')->nullable();
            $table->double('valorLab')->nullable();
            $table->double('valorLab_total')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('CASCADE');
            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('CASCADE');;
           


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorios');
    }
}
