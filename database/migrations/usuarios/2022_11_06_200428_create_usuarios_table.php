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
        Schema::create('usuarios', function (Blueprint $table) {
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
                ->string('usuario_nombre', 63)
                ->nullable(false)
                ->default("");
            
            $table
                ->string('usuario_apellido', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono_celular', 31)
                ->nullable(false)
                ->default("");

            $table
                ->string('email', 63)
                ->nullable(false)
                ->default("")
                ->comment("Sera el usuario para acceso.");

            $table
                ->string('password', 127)
                ->nullable(false)
                ->default("");

            $table
                ->integer('id_usuario_nivel')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("???");

            $table
                ->integer('id_usuario_refirio')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Id del usuario que lo afilió");

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
        Schema::dropIfExists('usuarios');
    }
};
