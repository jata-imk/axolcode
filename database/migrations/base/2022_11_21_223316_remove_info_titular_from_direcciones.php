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
        Schema::table('direcciones', function (Blueprint $table) {
            $table->dropColumn('nombre_titular');
            $table->dropColumn('apellido_titular');
            $table->dropColumn('email');
            $table->dropColumn('telefono');
            $table->dropColumn('telefono_codigo_pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direcciones', function (Blueprint $table) {
            $table
                ->string('nombre_titular', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('apellido_titular', 63)
                ->nullable(false)
                ->default("");

            $table
                ->string('email', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono', 31)
                ->nullable(false)
                ->default("");

            $table
                ->string("telefono_codigo_pais", 5)
                ->nullable(false)
                ->default("");
        });
    }
};
