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
        Schema::create('clases_servicios', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la clase.");

            $table
                ->string('nombre', 63)
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
        Schema::dropIfExists('clases_servicios');
    }
};
