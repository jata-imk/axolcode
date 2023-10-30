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
        Schema::table('sitios_turisticos', function (Blueprint $table) {
            $table->after("descripcion", function ($table) {
                $table
                    ->string("icono", 255)
                    ->nullable(false)
                    ->default("")
                    ->comment("Contenido del icono, dependiendo de su tipo puede ser una clase css, un path, etc.");

                $table
                    ->tinyInteger("id_icono_tipo")
                    ->unsigned()
                    ->default(0)
                    ->comment("Relacionado con la tabla iconos_tipos");
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
        Schema::table('sitios_turisticos', function (Blueprint $table) {
            $table->dropColumn("icono");
            $table->dropColumn("id_icono_tipo");
        });
    }
};
