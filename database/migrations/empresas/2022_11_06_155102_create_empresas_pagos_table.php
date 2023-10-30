<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
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
        Schema::create('empresas_pagos', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->integer('id_empresa')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger('id_forma_pago')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('monto', 8, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger('pago_online')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("0: No, 1: Si");

            $table
                ->string('autorizacion', 63)
                ->nullable(false)
                ->default("")
                ->comment("Autorización o referencia pago");

            $table
                ->timestamp("fecha_pago")
                ->nullable(false)
                ->default(new Expression('CURRENT_TIMESTAMP'))
                ->comment("Fecha y hora");

            $table
                ->date('periodo_pago_inicio')
                ->nullable(false);

            $table
                ->date('periodo_pago_fin')
                ->nullable(false);

            $table
                ->string('comprobante_pago', 127)
                ->nullable(false)
                ->default("")
                ->comment("Si no fue con tarjeta este campo representa la URL del comprobante de pago");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_pagos');
    }
};
