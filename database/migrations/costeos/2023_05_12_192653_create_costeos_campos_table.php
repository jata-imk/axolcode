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
        Schema::create('costeos_campos', function (Blueprint $table) {
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
                ->string("nombre", 127)
                ->nullable(false)
                ->default(0);

            $table
                ->string("identificador", 127)
                ->nullable(false)
                ->default("");

            $table
                ->decimal("valor_defecto", 10, 2)
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("definido_por_usuario")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->tinyInteger("definido_por_excursion")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string("excursion_columna", 127)
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
        Schema::dropIfExists('costeos_campos');
    }
};
