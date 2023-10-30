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
        Schema::create('excursiones_fechas', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la fecha.");

            $table
                ->integer('id_excursion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer('id_temporada')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->date("fecha_inicio")
                ->nullable(false);
            
            $table
                ->date("fecha_fin")
                ->nullable(false);

            $table
                ->decimal('adulto_sencilla', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_doble', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_triple', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_cuadruple', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_sencilla', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_doble', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_triple', 8, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('menor_cuadruple', 8, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('infante_sencilla', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('infante_doble', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('infante_triple', 8, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('infante_cuadruple', 8, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->integer('id_moneda')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger('publicar_fecha')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("0: No, 1: Si. Indica si la fecha estará disponible para reservar o no.");

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
        Schema::dropIfExists('excursiones_fechas');
    }
};
