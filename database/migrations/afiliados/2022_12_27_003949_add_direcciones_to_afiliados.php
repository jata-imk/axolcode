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
        Schema::table('afiliados', function (Blueprint $table) {
            $table->after('nombre_comercial', function ($table) {
                $table
                ->string("direccion_comercial", 255)
                ->nullable(false)
                ->default("");

                $table
                ->string("codigo_postal_comercial", 10)
                ->nullable(false)
                ->default("");

                $table
                ->string("pais_comercial", 10)
                ->nullable(false)
                ->default("");

                $table
                ->string("estado_comercial", 50)
                ->nullable(false)
                ->default("");

                $table
                ->string("ciudad_comercial", 50)
                ->nullable(false)
                ->default("");
            });

            $table->after('razon_social', function ($table) {
                $table
                ->string("direccion_fiscal", 255)
                ->nullable(false)
                ->default("");

                $table
                ->string("codigo_postal_fiscal", 10)
                ->nullable(false)
                ->default("");

                $table
                ->string("pais_fiscal", 10)
                ->nullable(false)
                ->default("");

                $table
                ->string("estado_fiscal", 50)
                ->nullable(false)
                ->default("");

                $table
                ->string("ciudad_fiscal", 50)
                ->nullable(false)
                ->default("");
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
        Schema::table('afiliados', function (Blueprint $table) {
            $table->dropColumn("ciudad_fiscal");
            $table->dropColumn("estado_fiscal");
            $table->dropColumn("pais_fiscal");
            $table->dropColumn("codigo_postal_fiscal");
            $table->dropColumn("direccion_fiscal");

            $table->dropColumn("ciudad_comercial");
            $table->dropColumn("estado_comercial");
            $table->dropColumn("pais_comercial");
            $table->dropColumn("codigo_postal_comercial");
            $table->dropColumn("direccion_comercial");
        });
    }
};
