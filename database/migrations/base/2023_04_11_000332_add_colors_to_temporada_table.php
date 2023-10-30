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
        Schema::table('temporadas', function (Blueprint $table) {
            $table->after("nombre", function ($table) {
                $table
                    ->string("color", 7)
                    ->nullable(false)
                    ->default("")
                    ->comment("Código Hexadecimal del color de acento de la temporada");
                
                $table
                    ->string("background_color", 7)
                    ->nullable(false)
                    ->default("")
                    ->comment("Código Hexadecimal del color de fondo de la temporada");
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporadas', function (Blueprint $table) {
            $table->dropColumn("color");
            $table->dropColumn("background_color");
        });
    }
};
