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
        Schema::create('excursiones_itinerarios', function (Blueprint $table) {
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
                ->integer('id_excursion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->text("contenido")
                ->nullable(false)
                ->comment("HTML");

            $table
                ->tinyInteger("dia")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("A que dia de la excursion corresponde el itinerario.");

            $table
                ->string('icono', 127)
                ->nullable(false)
                ->default("")
                ->comment("Path al icono que representa la actividad o el sitio mas representativo de este dia del itinerario.");

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
        Schema::dropIfExists('excursiones_itinerarios');
    }
};
