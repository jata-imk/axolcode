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
        Schema::table('clientes_status', function (Blueprint $table) {
            $table->after("descripcion", function ($table) {
                $table
                    ->string("color", 7)
                    ->nullable(false)
                    ->default("")
                    ->comment("Codigo Hexadecimal del color de acento del status");
                
                    $table
                    ->string("background_color", 7)
                    ->nullable(false)
                    ->default("")
                    ->comment("Codigo Hexadecimal del color de acento del status");
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
        Schema::table('clientes_status', function (Blueprint $table) {
            $table->dropColumn("color");
            $table->dropColumn("background_color");
        });
    }
};
