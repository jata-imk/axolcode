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
            $table->dropColumn("id_excursion");
            $table->dropColumn("adulto_sencilla");
            $table->dropColumn("adulto_doble");
            $table->dropColumn("adulto_triple");
            $table->dropColumn("adulto_cuadruple");
            $table->dropColumn("menor_sencilla");
            $table->dropColumn("menor_doble");
            $table->dropColumn("menor_triple");
            $table->dropColumn("menor_cuadruple");
            $table->dropColumn("infante_sencilla");
            $table->dropColumn("infante_doble");
            $table->dropColumn("infante_triple");
            $table->dropColumn("infante_cuadruple");
            $table->dropColumn("id_moneda");

            $table->after("id_usuario", function ($table) {
                $table
                    ->integer("id_excursion_temporada_costo")
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
        Schema::table('excursiones_fechas', function (Blueprint $table) {
            $table
                ->integer('id_excursion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

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
        });
    }
};
