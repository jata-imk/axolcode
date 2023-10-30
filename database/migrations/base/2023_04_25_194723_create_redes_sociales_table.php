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
        Schema::create('redes_sociales', function (Blueprint $table) {
            $table
                ->smallInteger("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->string('nombre', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('icon', 127)
                ->nullable(false)
                ->default("")
                ->comment("A font awesome icon for the item.");

            $table
                ->string('icon_color', 7)
                ->nullable(false)
                ->default("")
                ->comment("Código Hexadecimal del color de acento del status");

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
        Schema::dropIfExists('redes_sociales');
    }
};
