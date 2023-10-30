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
        Schema::create('sitios_turisticos_imagenes', function (Blueprint $table) {
            $table
                ->smallInteger("id")
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
                ->integer('id_sitio_turistico')
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
                ->string('path', 255)
                ->nullable(false)
                ->default("");

            $table
                ->tinyInteger('principal_tarjetas')
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->tinyInteger('principal_portadas')
                ->unsigned()
                ->nullable(false)
                ->default(0);

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
        Schema::dropIfExists('sitios_turisticos_imagenes');
    }
};
