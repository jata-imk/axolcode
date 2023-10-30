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
        Schema::create('excursiones_reservaciones_paxes', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->integer('id_excursion_reservacion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('nombre', 63)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('apellido', 63)
                ->nullable(false)
                ->default("");

            $table
                ->tinyInteger('id_parentesco')
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->date("fecha_nacimiento")
                ->nullable(false);

            $table
                ->tinyInteger('adulto')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 2: No");

            $table
                ->tinyInteger('menor')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 2: No");

            $table
                ->tinyInteger('infante')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 2: No");

            $table
                ->string('identificacion', 127)
                ->nullable(false)
                ->default("");
            
            $table
                ->integer('id_excursion_reservacion_habitacion')
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
        Schema::dropIfExists('excursiones_reservaciones_paxes');
    }
};
