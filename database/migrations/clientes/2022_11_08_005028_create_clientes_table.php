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
        Schema::create('clientes', function (Blueprint $table) {
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
                ->integer('id_usuario_alta')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que dio de alta al cliente.");

            $table
                ->integer('id_ejecutivo')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Ejecutivo a cargo del cliente.");

            $table
                ->date('fecha_alta')
                ->nullable(false);

            $table
                ->integer('id_status')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('nombre', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('apellido', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono_celular', 31)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono_casa', 31)
                ->nullable(false)
                ->default("");

            $table
                ->string('email_principal', 127)
                ->nullable(false)
                ->default("");

                $table
                ->string('email_secundario', 127)
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
        Schema::dropIfExists('clientes');
    }
};
