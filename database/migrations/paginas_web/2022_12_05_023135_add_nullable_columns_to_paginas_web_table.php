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
        Schema::table('paginas_web', function (Blueprint $table) {
            $table
                ->string('pagina_web', 127)
                ->nullable()
                ->change();

            $table
                ->string('facebook', 127)
                ->nullable()
                ->change();

            $table
                ->string('instagram', 127)
                ->nullable()
                ->change();

            $table
                ->string('twitter', 127)
                ->nullable()
                ->change();
            
                $table
                ->string('pinterest', 127)
                ->nullable()
                ->change();

            $table
                ->string('tripadvisor', 127)
                ->nullable()
                ->change();

            $table
                ->string('youtube', 127)
                ->nullable()
                ->change();

            $table
                ->string('linkedin', 127)
                ->nullable()
                ->change();

            $table
                ->string('tiktok', 127)
                ->nullable()
                ->change();

            $table
                ->string('google', 127)
                ->nullable()
                ->change();

            $table
                ->string('logo_web', 127)
                ->nullable()
                ->change();

            $table
                ->string('whatsapp', 127)
                ->nullable()
                ->change()
                ->comment("WhatsApp que aparece en la pagina web.");

            $table
                ->string('telefono', 127)
                ->nullable()
                ->change();

            $table
                ->text("footer_copyright")
                ->nullable()
                ->change();

            $table
                ->text("politicas")
                ->nullable()
                ->change();
            
            $table
                ->text("aviso_privacidad")
                ->nullable()
                ->change();

            $table->after("aviso_privacidad", function ($table) {
                $table
                    ->text("snippet_header")
                    ->nullable();

                $table
                    ->text("snippet_footer")
                    ->nullable();

                $table
                    ->text("snippet_reviews")
                    ->nullable();
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
        Schema::table('paginas_web', function (Blueprint $table) {
            $table
                ->string('pagina_web', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('facebook', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('instagram', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('twitter', 127)
                ->nullable(false)
                ->change();
            
                $table
                ->string('pinterest', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('tripadvisor', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('youtube', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('linkedin', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('tiktok', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('google', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('logo_web', 127)
                ->nullable(false)
                ->change();

            $table
                ->string('whatsapp', 127)
                ->nullable(false)
                ->change()
                ->comment("WhatsApp que aparece en la pagina web.");

            $table
                ->string('telefono', 127)
                ->nullable(false)
                ->change();

            $table
                ->text("footer_copyright")
                ->nullable(false)
                ->change();

            $table
                ->text("politicas")
                ->nullable(false)
                ->change();
            
            $table
                ->text("aviso_privacidad")
                ->nullable(false)
                ->change();

            $table->dropColumn("snippet_header");
            $table->dropColumn("snippet_footer");
            $table->dropColumn("snippet_reviews");
        });
    }
};
