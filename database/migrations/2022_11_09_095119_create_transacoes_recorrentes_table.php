<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacoes_recorrentes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo');
            $table->decimal('valor', 10, 2);
            $table->string('periodo');
            $table->string('dia_do_mes');
            $table->date('data_primeira_transacao');
            $table->date('data_proxima_transacao');
            $table->string('tag');
            $table->string('descricao');

            $table->foreignId('projeto_id')->nullable();

            $table->foreign('projeto_id')->references('id')->on('projetos')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('transacoes_recorrentes');
    }
};
