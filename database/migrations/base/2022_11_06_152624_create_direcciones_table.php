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
        Schema::create('direcciones', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la dirección.");

            $table
                ->string('nombre_titular', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('apellido_titular', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('email', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono', 31)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('linea1', 127)
                ->nullable(false)
                ->default("")
                ->comment("Primera línea de dirección del usuario. Usada comúnmente para indicar la calle y número exterior e interior.");

            $table
                ->string('linea2', 127)
                ->nullable(false)
                ->default("")
                ->comment("Segunda línea de la dirección del usuario. Usada comúnmente para indicar condominio, suite o delegación.");

            $table
                ->string('linea3', 127)
                ->nullable(false)
                ->default("")
                ->comment("Tercer línea de la dirección del usuario. Usada comúnmente para indicar la colonia.");

            $table
                ->string('codigo_postal', 10)
                ->nullable(false)
                ->default("");

            $table
                ->string('ciudad', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('estado', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('codigo_pais', 3)
                ->nullable(false)
                ->default("")
                ->comment("Código del país del usuario en formato ISO_3166-1.");
                
            $table
                ->string('referencias', 255)
                ->nullable(false)
                ->default("");

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
        Schema::dropIfExists('direcciones');
    }
};
