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
        Schema::table('roles_menus', function (Blueprint $table) {
            $table->after("id_menu", function ($table) {
                $table
                    ->tinyInteger("crear")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);

                $table
                    ->tinyInteger("ver")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);

                $table
                    ->tinyInteger("editar")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);

                $table
                    ->tinyInteger("eliminar")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);
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
        Schema::table('roles_menus', function (Blueprint $table) {
            $table->dropColumn("crear");
            $table->dropColumn("ver");
            $table->dropColumn("editar");
            $table->dropColumn("eliminar");
        });
    }
};
