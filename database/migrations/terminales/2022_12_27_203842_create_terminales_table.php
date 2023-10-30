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
        Schema::create('terminales', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

                $table
                ->string('nombre', 100)
                ->nullable(false)
                ->default("");

                $table
                ->integer('estatus')
                ->unsigned()
                ->nullable(false)
                ->default(1);

                $table
                ->decimal('comision_base', 5, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('tres_meses', 5, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('seis_meses', 5, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('nueve_meses', 5, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('doce_meses', 5, 2)
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->decimal('precio_base', 5, 2)
                ->unsigned()
                ->nullable(true)
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
        Schema::dropIfExists('terminales');
    }
};
