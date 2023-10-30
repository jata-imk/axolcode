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
            Schema::rename("id_temporada", "id_temporada_costo");
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
            Schema::rename("id_temporada_costo", "id_temporada");

        });
    }
};
