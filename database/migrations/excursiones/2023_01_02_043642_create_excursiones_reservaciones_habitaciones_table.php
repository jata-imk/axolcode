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
        Schema::create('excursiones_reservaciones_habitaciones', function (Blueprint $table) {
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
                ->string('hotel', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('tipo_habitacion', 15)
                ->nullable(false)
                ->default("");

            $table
                ->string('no_reservacion', 15)
                ->nullable(false)
                ->default("");

            $table
                ->string('titular', 63)
                ->nullable(false)
                ->default("");

            $table
                ->tinyInteger('paxes')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('observaciones', 255)
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
        Schema::dropIfExists('excursiones_reservaciones_habitaciones');
    }
};
