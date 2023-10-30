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
        Schema::create('excursiones_reservaciones_vuelos', function (Blueprint $table) {
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
                ->integer('id_excursion_reservacion_pax')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger('llegada')
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->tinyInteger('regreso')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('lugar_origen', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('lugar_destino', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('aerolinea', 63)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('no_vuelo', 10)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('no_asiento', 10)
                ->nullable(false)
                ->default("");

            $table
                ->timestamp('fecha_y_hora')
                ->nullable(false);
            
            $table
                ->decimal('precio', 10, 2)
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
        Schema::dropIfExists('excursiones_reservaciones_vuelos');
    }
};
