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
        Schema::table('empresas_pagos', function (Blueprint $table) {
            $table->after("monto", function ($table) {
                $table
                    ->integer('moneda_id')
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);
    
                $table
                    ->decimal('tipo_cambio', 10, 4)
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
        Schema::table('empresas_pagos', function (Blueprint $table) {
            $table->dropColumn('moneda_id');
            $table->dropColumn('tipo_cambio');
        });
    }
};
