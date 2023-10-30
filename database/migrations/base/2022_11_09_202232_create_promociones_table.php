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
        Schema::create('promociones', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la promoción.");

            $table
                ->tinyInteger('tipo_promocion')
                ->nullable(false)
                ->default(0)
                ->comment("1: Descuento, 2: Menor gratis.");

            $table
                ->tinyInteger('tipo_descuento')
                ->nullable(false)
                ->default(0)
                ->comment("1: Porcentaje, 2: Monto.");

            $table
                ->decimal('valor_promocion', 8, 2)
                ->nullable(false)
                ->default(0)
                ->comment("Ya sea monto $$$ o porcentaje %.");

            $table
                ->string('icono', 127)
                ->nullable(false)
                ->default("")
                ->comment("Path al icono que representa a la promoción (Si existe).");

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
        Schema::dropIfExists('promociones');
    }
};
