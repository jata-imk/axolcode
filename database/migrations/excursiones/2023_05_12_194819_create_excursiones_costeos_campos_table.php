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
        Schema::create('excursiones_costeos_campos', function (Blueprint $table) {
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
                ->integer("id_excursion_costeo")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer("id_costeo_campo")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->decimal("valor", 10, 2)
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
        Schema::dropIfExists('excursiones_costeos_campos');
    }
};
