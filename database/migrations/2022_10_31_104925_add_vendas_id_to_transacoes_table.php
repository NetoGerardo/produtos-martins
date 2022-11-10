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
        Schema::table('transacoes', function (Blueprint $table) {

            $table->foreignId('venda_id')->nullable();

            $table->date('data_vencimento')->nullable();
            $table->boolean('transacao_paga')->default(0);

            $table->foreign('venda_id')->references('id')->on('vendas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transacoes', function (Blueprint $table) {
            //
        });
    }
};
