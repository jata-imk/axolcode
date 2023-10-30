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
        Schema::create('empresas', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->string('nombre_comercial', 127)
                ->nullable(false)
                ->default("");
            $table
                ->string('razon_social', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono_oficina', 31)
                ->nullable(false)
                ->default("");
            $table
                ->string('telefono_celular', 31)
                ->nullable(false)
                ->default("");
            
            $table
                ->integer("id_direccion_comercial")
                ->unsigned()
                ->nullable(false)
                ->default(0);
            $table
                ->integer("id_direccion_fiscal")
                ->unsigned()
                ->nullable(false)
                ->default(0);
            
            $table
                ->string('rfc', 15)
                ->nullable(false)
                ->default("");

            $table
                ->tinyInteger("id_tipo_persona")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment('1: Fisica, 2: Moral');
            $table
                ->tinyInteger("id_tipo_empresa")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment('1: Agencia viajes, 2: Vendedor, 3: Bloguero');

            $table
                ->date('fecha_alta')
                ->nullable(false);
            $table
                ->date('fecha_vencimiento')
                ->nullable(false);
            $table
                ->date('fecha_ultimo_pago')
                ->nullable(false);

            $table
                ->tinyInteger("id_empresa_status")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment('0: Inactivo, 1: Inactivo por falta de pago, 2: Activo, 3: Suspendido');

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
        Schema::dropIfExists('empresas');
    }
};
