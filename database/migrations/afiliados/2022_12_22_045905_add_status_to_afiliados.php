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
            $table->after('id_nivel', function ($table) {
                $table
                ->integer("estatus")
                ->unsigned()
                ->nullable(false)
                ->default(1);
            });

            $table->after("telefono_oficina", function ($table) {
                $table
                    ->string("telefono_oficina_codigo_pais", 5)
                    ->nullable(false)
                    ->default("");

                $table
                    ->string("telefono_oficina_iso_pais", 5)
                    ->nullable(false)
                    ->default("")
                    ->comment("Código del país en formato ISO_3166-1.");
            });

            $table->after("telefono_celular", function ($table) {
                $table
                    ->string("telefono_celular_codigo_pais", 5)
                    ->nullable(false)
                    ->default("");

                $table
                    ->string("telefono_celular_iso_pais", 5)
                    ->nullable(false)
                    ->default("")
                    ->comment("Código del país en formato ISO_3166-1.");
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
            $table->dropColumn("estatus");
            $table->dropColumn("telefono_oficina_codigo_pais");
            $table->dropColumn("telefono_oficina_iso_pais");
            $table->dropColumn("telefono_celular_codigo_pais");
            $table->dropColumn("telefono_celular_iso_pais");
        });
    }
};
