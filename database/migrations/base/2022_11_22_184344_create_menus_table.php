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
        Schema::create('menus', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->string('text', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('icon', 63)
                ->nullable(false)
                ->default("")
                ->comment("A font awesome icon for the item.");

            $table
                ->string('icon_color', 31)
                ->nullable(false)
                ->default("")
                ->comment("An AdminLTE color for the icon (info, primary, etc).");

            $table
                ->string('url', 63)
                ->nullable(false)
                ->default("")
                ->comment("An URL path, normally used on link items.");
            
            $table
                ->string('label', 31)
                ->nullable(false)
                ->default("")
                ->comment("Text for a badge associated with the item.");
            
            $table
                ->string('label_color', 31)
                ->nullable(false)
                ->default("")
                ->comment("An AdminLTE color for the badge (info, primary, etc).");
            
            $table
                ->string('key', 31)
                ->nullable(false)
                ->default("")
                ->comment("An unique identifier key for reference the item.");

            $table
                ->string('add_in', 31)
                ->nullable(false)
                ->default("")
                ->comment("Elemento padre, si esta definido quiere decir que el elemento actual es un submenú.");

            $table
                ->string('section', 31)
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
        Schema::dropIfExists('menus');
    }
};
