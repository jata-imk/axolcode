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
        Schema::create('excursiones_reservaciones', function (Blueprint $table) {
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
                ->integer('id_usuario')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que dio de alta la reservación");

            $table
                ->integer('id_cliente')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que dio de alta la reservación");

            $table
                ->integer('id_ejecutivo')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Ejecutivo que está a cargo del seguimiento del cliente");

            $table
                ->integer('id_excursion')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Es la excursión que se está reservando");

            $table
                ->integer('id_promocion')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("En caso de que se haya aplicado alguna promoción con esta relación obtenemos los detalles");

            $table
                ->integer('id_fecha')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Fechas en las que se llevara a cabo la excursión");

            $table
                ->date("fecha_inicio")
                ->nullable(false)
                ->comment("Para fechas personalizadas");
            
            $table
                ->date("fecha_fin")
                ->nullable(false)
                ->comment("Para fechas personalizadas");

            $table
                ->tinyInteger("vuelos")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 0: No; Indica si se incluyen vuelos.");

            $table
                ->tinyInteger("hoteleria")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 0: No; Indica si se incluye hotelería.");

            $table
                ->tinyInteger("menores")
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->tinyInteger("infantes")
                ->unsigned()
                ->nullable(false)
                ->default(0);
                
            // Pasajeros cantidades
            $table
                ->tinyInteger("cantidad_adultos")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("cantidad_menores")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("cantidad_infantes")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            // Finanzas
            $table
                ->tinyInteger("tipo_venta")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Interna, 2: Por medio de afiliados.");

            $table
                ->integer('id_afiliado')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Si aplica");

            $table
                ->integer('id_forma_pago')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('contrato', 127)
                ->nullable(false)
                ->default("");

            $table
                ->integer('id_moneda')
                ->unsigned()
                ->nullable(false)
                ->default(0);

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
        Schema::dropIfExists('excursiones_reservaciones');
    }
};
