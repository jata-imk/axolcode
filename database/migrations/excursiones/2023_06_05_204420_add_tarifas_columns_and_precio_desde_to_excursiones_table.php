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
        Schema::table('excursiones', function (Blueprint $table) {
            $table->after("id_moneda", function ($table) {
                $table
                    ->tinyInteger("tipo_tarifa")
                    ->unsigned()
                    ->nullable(false)
                    ->default(1)
                    ->comment("1: Por persona, 2: Grupal");
                
                $table
                    ->tinyInteger("cantidad_pasajeros_grupo")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0)
                    ->comment("Si el precio es grupal, este campo indica de cuantas personas es el grupo");
            });

            $table->after("metodo_calculo_precio", function ($table) {
                $table
                    ->decimal("precio_desde", 10, 2)
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excursiones', function (Blueprint $table) {
            $table->dropColumn("tipo_tarifa");
            $table->dropColumn("cantidad_pasajeros_grupo");
            $table->dropColumn("precio_desde");
        });
    }
};
