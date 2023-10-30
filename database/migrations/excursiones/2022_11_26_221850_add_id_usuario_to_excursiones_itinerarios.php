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
        Schema::table('excursiones_itinerarios', function (Blueprint $table) {
            $table->after("id_empresa", function ($table) {
                $table
                    ->integer("id_usuario")
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
        Schema::table('excursiones_itinerarios', function (Blueprint $table) {
            $table->dropColumn("id_usuario");
        });
    }
};
