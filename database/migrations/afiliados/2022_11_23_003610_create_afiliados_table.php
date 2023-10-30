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
        Schema::create('afiliados', function (Blueprint $table) {
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
                ->default(0);

            $table
                ->integer('id_nivel')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('nombre_comercial', 127)
                ->nullable(false)
                ->default("");
                
            $table
                ->string('razon_social', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('rfc', 15)
                ->nullable(false)
                ->default("");

            $table
                ->string('url', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('link_afiliado', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('nombre_contacto', 63)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('apellido_contacto', 63)
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
                ->date('fecha_alta')
                ->nullable(false);

            $table
                ->smallInteger('compras_realizadas')
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
        Schema::dropIfExists('afiliados');
    }
};
