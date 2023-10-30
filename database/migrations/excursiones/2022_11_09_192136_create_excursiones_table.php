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
        Schema::create('excursiones', function (Blueprint $table) {
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
                ->comment("Usuario que dio de alta la excursión");

            $table
                ->integer("id_clase_servicio")
                ->unsigned()
                ->nullable(false)
                ->default(0);

            $table
                ->string('nombre', 127)
                ->nullable(false)
                ->default("");

            $table
                ->text('descripcion')
                ->nullable(false);

            $table
                ->string('youtube', 127)
                ->nullable(false)
                ->default("")
                ->comment("Link al video de YouTube que publicita la excursión");

            $table
                ->tinyInteger("menores")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 0: No; Indica si se admiten menores o no en la excursión.");

            $table
                ->tinyInteger("infantes")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("1: Si, 0: No; Indica si se admiten infantes o no en la excursión.");

            $table
                ->tinyInteger("cantidad_dias")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Indica cuantos días dura la excursión.");

            $table
                ->tinyInteger("publicar_excursion")
                ->unsigned()
                ->nullable(false)
                ->default(0)
                ->comment("Indica si estará o no disponible el tour para su reserva.");

            $table
                ->string('titulo_sitio', 127)
                ->nullable(false)
                ->default("")
                ->comment("Pare el CEO.");

            $table
                ->string('descripcion_sitio', 255)
                ->nullable(false)
                ->default("")
                ->comment("Pare el CEO.");
                
            $table
                ->string('keywords_sitio', 255)
                ->nullable(false)
                ->default("")
                ->comment("Pare el CEO.");

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
        Schema::dropIfExists('excursiones');
    }
};
