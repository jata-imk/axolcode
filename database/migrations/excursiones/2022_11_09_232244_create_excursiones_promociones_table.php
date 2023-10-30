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
        Schema::create('excursiones_promociones', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la promoción para la excursion indicada en la columna id_excursion.");

            $table
                ->tinyInteger('paxes_promocion')
                ->nullable(false)
                ->default(0)
                ->comment("A partir de cuantos pasajeros es la promoción");

            $table
                ->string("codigo", 31)
                ->nullable(false)
                ->default("")
                ->comment("E.g.: CANCUN50(Tour a cancún con el 50% de descuento).");

            $table
                ->tinyInteger("limitado")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("0: No, 1: Si");
            
            $table
                ->smallInteger("limite")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Cantidad de excursiones en linea");

            $table
                ->date("booking_window_inicio")
                ->nullable(true)
                ->comment("Reservando de que fecha a que fecha");

            $table
                ->date("booking_window_fin")
                ->nullable(true);

            $table
                ->date("travel_window_inicio")
                ->nullable(true)
                ->comment("Viajando de que fecha a que fecha");

            $table
                ->date("travel_window_fin")
                ->nullable(true);

            $table
                ->date("vigencia")
                ->nullable(false)
                ->comment("Fecha en la que expira la promoción. (En caso de no aplicar booking_windows)");

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
        Schema::dropIfExists('excursiones_promociones');
    }
};
