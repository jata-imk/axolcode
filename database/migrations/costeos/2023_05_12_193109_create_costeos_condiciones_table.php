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
        Schema::create('costeos_condiciones', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->integer("id_empresa")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_usuario")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_costeo")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string("condicion", 255)
                ->nullable(false)
                ->default(0);

            $table
                ->string("formula_precio", 255)
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
        Schema::dropIfExists('costeos_condiciones');
    }
};