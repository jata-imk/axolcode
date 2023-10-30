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
        Schema::create('excursiones_costeos', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->integer("id_empresa")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_usuario")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_excursion")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_temporada")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_clase_servicio")
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->string("id_habitacion_tipo", 64)
                ->nullable(false)
                ->default("");

            $table
                ->integer("id_costeo")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->decimal("descuento_menores", 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("descuento_menores_tipo")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Porcentaje, 2: Monto.");
            
            $table
                ->decimal("descuento_infantes", 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("descuento_infantes_tipo")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Porcentaje, 2: Monto.");

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
        Schema::dropIfExists('excursiones_costeos');
    }
};
