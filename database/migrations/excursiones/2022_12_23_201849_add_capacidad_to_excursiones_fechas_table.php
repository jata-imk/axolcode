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
        Schema::table('excursiones_fechas', function (Blueprint $table) {
            $table->after('fecha_fin', function ($table) {
                $table
                    ->smallInteger("cupo")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0)
                    ->comment("Capacidad maxima de pasajeros para una fecha.");
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
        Schema::table('excursiones_fechas', function (Blueprint $table) {
            $table->dropColumn("cupo");
        });
    }
};
