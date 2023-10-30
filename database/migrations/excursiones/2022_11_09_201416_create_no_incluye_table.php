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
        Schema::create('no_incluye', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta el registro.");

            $table
                ->string('nombre', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('descripcion', 255)
                ->nullable(false)
                ->default("");

            $table
                ->string('icono', 127)
                ->nullable(false)
                ->default("")
                ->comment("Path al icono que representa el servicio (Si existe).");
                
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
        Schema::dropIfExists('no_incluye');
    }
};
