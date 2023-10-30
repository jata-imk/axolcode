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
                    ->tinyInteger("metodo_calculo_precio")
                    ->unsigned()
                    ->nullable(false)
                    ->default(1)
                    ->comment("1: Asignación directa, 2: Mediante formula de costeo");
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
            $table->dropColumn("metodo_calculo_precio");
        });
    }
};
