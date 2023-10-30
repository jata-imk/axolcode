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
        Schema::table('excursiones_promociones', function (Blueprint $table) {
            $table->after("id_usuario", function ($table) {
                $table
                    ->integer("id_excursion")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);

                $table
                    ->integer("id_promocion")
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
        Schema::table('excursiones_promociones', function (Blueprint $table) {
            $table->dropColumn("id_excursion");
            $table->dropColumn("id_promocion");
        });
    }
};
