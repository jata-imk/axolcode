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
            $table->after("calendario", function ($table) {
                $table
                    ->string("dias_disponible", 15)
                    ->nullable(false)
                    ->default("")
                    ->comment("Dias que se encontrará disponible la excursion en caso de no estar calendarizada, 0 (para Domingo) hasta 6 (para Sábado)");
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
            $table->dropColumn("dias_disponible");
        });
    }
};
