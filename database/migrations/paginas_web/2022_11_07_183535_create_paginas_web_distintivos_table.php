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
        Schema::create('paginas_web_distintivos', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();
            
            $table
                ->integer('id_empresa')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer('id_pagina_web')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer('id_usuario')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que dio de alta el distintivo.");

            $table
                ->string('nombre', 127)
                ->nullable(false)
                ->default("")
                ->comment("Nombre de la organización a la que pertenece o que brinda el distintivo, certificado, reconocimiento, etc.");

            $table
                ->string('logo', 127)
                ->nullable(false)
                ->default("")
                ->comment("Path del logotipo.");

            $table
                ->string('link', 127)
                ->nullable(false)
                ->default("")
                ->comment("Si se especifica, se llevará a este enlace cuando se le de clic a la imagen del distintivo.");

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
        Schema::dropIfExists('paginas_web_distintivos');
    }
};
