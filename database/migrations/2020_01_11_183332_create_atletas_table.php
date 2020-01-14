<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtletasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atletas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('run');
            $table->string('nombre');
            $table->string('correo')->nullable()->default('SIN CORREO');
            $table->string('nombre_equipo')->nullable()->default('SIN EQUIPO');
            $table->smallInteger('encargado')->default(0);
            $table->string('fecha_nacimiento')->nullable()->default('SIN FECHA');
            $table->string('box')->default('SIN BOX');

            $table->unsignedBigInteger('polera_id');
            $table->foreign('polera_id')->references('id')->on('poleras');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');

            $table->smallInteger('pago')->default(0);
            $table->smallInteger('invitado')->default(0);
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
        Schema::dropIfExists('atletas');
    }
}
