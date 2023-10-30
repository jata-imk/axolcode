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
        Schema::create('terminales_empresas', function (Blueprint $table) {
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
                ->integer('id_terminal')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->integer('id_afiliacion')
                ->unsigned()
                ->nullable(false)
                ->default(0);

                $table
                ->integer('id_medio')
                ->unsigned()
                ->nullable(true)
                ->default(0)
                ->comment("Si aplica el caso. Banregio si");

                $table
                ->string('enviroment', 63)
                ->nullable(false)
                ->default("sandbox")
                ->comment("Si aplica el caso.");

                $table
                ->string('url_respuesta', 255)
                ->nullable(false)
                ->default("")
                ->comment("URL que mostrara la respuesta de la transaccion.");

                $table
                ->string('llave_privada', 255)
                ->nullable(true)
                ->default("")
                ->comment("Si aplica el caso.");

                $table
                ->string('llave_publica', 255)
                ->nullable(true)
                ->default("")
                ->comment("Si aplica el caso.");

                $table
                ->integer('estatus')
                ->unsigned()
                ->nullable(false)
                ->default(1);


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
        Schema::dropIfExists('terminales_empresas');
    }
};
