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
        Schema::create('excursiones_imagenes', function (Blueprint $table) {
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
                ->integer('id_usuario')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que subió la imagen.");

            $table
                ->integer('id_excursion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string("titulo", 127)
                ->nullable(false)
                ->default("");
            
            $table
                ->string("descripcion", 255)
                ->nullable(false)
                ->default("");
            
            $table
                ->string("leyenda", 255)
                ->nullable(false)
                ->default("");

            $table
                ->string("texto_alternativo", 255)
                ->nullable(false)
                ->default("");

            $table
                ->string("path", 127)
                ->nullable(false)
                ->default("");

            $table
                ->tinyInteger("dia")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("A que dia de la excursion corresponde la foto (Para relacionar la foto con los días del itinerario).");
            
            $table
                ->tinyInteger("principal_tarjetas")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("0: No, 1: Si.");

            $table
                ->tinyInteger("principal_portadas")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("0: No, 1: Si.");

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
        Schema::dropIfExists('excursiones_imagenes');
    }
};
