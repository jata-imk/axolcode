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
        Schema::create('excursiones_temporadas_costos', function (Blueprint $table) {
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
                ->decimal('adulto_sencilla', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_doble', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_triple', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('adulto_cuadruple', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_sencilla', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_doble', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('menor_triple', 10, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('menor_cuadruple', 10, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('infante_sencilla', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('infante_doble', 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->decimal('infante_triple', 10, 2)
                ->nullable(false)
                ->default(0);
            
            $table
                ->decimal('infante_cuadruple', 10, 2)
                ->nullable(false)
                ->default(0);

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
        Schema::dropIfExists('excursiones_temporadas_costos');
    }
};
