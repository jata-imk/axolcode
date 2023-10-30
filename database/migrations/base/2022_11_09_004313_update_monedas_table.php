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
        Schema::table('monedas', function (Blueprint $table) {
            $table->after("iso", function ($table) {    
                $table
                    ->decimal('tipo_cambio', 10, 4)
                    ->unsigned()
                    ->nullable(false)
                    ->default(0)
                    ->comment("En relación con el peso mexicano.");
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
        Schema::table('monedas', function (Blueprint $table) {
            $table->dropColumn('tipo_cambio');
        });
    }
};
