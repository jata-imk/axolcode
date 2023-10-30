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
        Schema::create('links_pago', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

                $table
                ->tinyInteger('id_empresa')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->tinyInteger('id_usuario')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->tinyInteger('id_terminal')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('monto', 10, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->tinyInteger('meses')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('comision_base', 10, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('sobre_tasa', 10, 2)
                ->unsigned()
                ->nullable(true)
                ->default(0);

                $table
                ->string('nombre_cliente', 255)
                ->nullable(false)
                ->default("");

                $table
                ->string('respuesta', 5)
                ->nullable(true)
                ->default("");

                $table
                ->string('autorizacion', 20)
                ->nullable(true)
                ->default("");

                $table
                ->string('clave', 20)
                ->nullable(false)
                ->default("");

                $table
                ->string('link', 50)
                ->nullable(false)
                ->default("");

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
        Schema::dropIfExists('links_pago');
    }
};
