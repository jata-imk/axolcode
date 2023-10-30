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
        Schema::table('promociones', function (Blueprint $table) {
            $table->after("id_usuario", function ($table) {
                $table
                    ->string("nombre", 63)
                    ->nullable(false)
                    ->default("");

                $table
                    ->string("descripcion", 255)
                    ->nullable(false)
                    ->default("");
            });

            $table->renameColumn('tipo_promocion', 'descuento');

            $table->renameColumn('icono', 'flyer');
            $table
                ->string("icono", 255)
                ->change();

            $table->after("icono", function ($table) {
                $table
                    ->tinyInteger("publicar")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0)
                    ->comment("0: No se publica, 1: Se publica en la sección de promociones");
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
        Schema::table('promociones', function (Blueprint $table) {
            $table->dropColumn("nombre");
            $table->dropColumn("descripcion");
            $table->dropColumn("publicar");

            $table->renameColumn('descuento', 'tipo_promocion');

            $table->renameColumn('flyer', 'icono');
            $table
                ->string("icono", 127)
                ->change();
        });
    }
};
