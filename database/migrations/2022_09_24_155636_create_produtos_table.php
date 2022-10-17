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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('quantidade');
            $table->integer('quantidade_disponivel');
            $table->integer('quantidade_vendida')->default(0);
            $table->decimal('valor_compra', 10, 2);
            $table->decimal('valor_venda', 10, 2);

            $table->foreignId('projeto_id')->nullable();
            $table->foreignId('categoria_id')->nullable();

            $table->foreign('categoria_id')->references('id')->on('categorias')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('produtos');
    }
};
