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
        Schema::table('excursiones', function (Blueprint $table) {
            $table->after("infantes", function ($table) {
                $table
                    ->tinyInteger("hoteleria")
                    ->unsigned()
                    ->nullable(false)
                    ->default(0);

                $table
                    ->tinyInteger("calendario")
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
        Schema::table('excursiones', function (Blueprint $table) {
            $table->dropColumn("hoteleria");
            $table->dropColumn("calendario");
        });
    }
};