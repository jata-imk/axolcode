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
        Schema::create('paginas_web', function (Blueprint $table) {
            $table
                ->integer("id")
                ->unsigned()
                ->autoIncrement();

            $table
                ->integer('id_empresa')
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->integer('id_usuario')
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Usuario que dio de alta la información de pagina web de la empresa.");

            $table
                ->string('pagina_web', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('logo_web', 127)
                ->nullable(false)
                ->default("");

            $table
                ->string('telefono', 127)
                ->nullable(false)
                ->default("")
                ->comment("Teléfono que aparece en la pagina web, puede ser diferente al de la empresa.");

            $table
                ->text("footer_copyright")
                ->nullable(false)
                ->comment("HTML que aparecerá en la sección FOOTER de la pagina web de la empresa.");

            $table
                ->text("politicas")
                ->nullable(false)
                ->comment("HTML que aparecerá en la pagina de TÉRMINOS Y CONDICIONES de la pagina web de la empresa.");
            
            $table
                ->text("aviso_privacidad")
                ->nullable(false)
                ->comment("HTML que aparecerá en la pagina de AVISO DE PRIVACIDAD de la pagina web de la empresa.");

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
        Schema::dropIfExists('paginas_web');
    }
};
