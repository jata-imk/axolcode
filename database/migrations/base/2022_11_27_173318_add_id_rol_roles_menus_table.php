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
            $table->after("id_usuario", function ($table) {
                $table
                    ->integer("id_rol")
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
            $table->dropColumn("id_rol");
        });
    }
};
