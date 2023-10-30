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
            $table->dropColumn("id_clase_servicio");
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
            $table
                ->integer("id_clase_servicio")
                ->unsigned()
                ->nullable(false)
                ->default(0);
        });
    }
};
