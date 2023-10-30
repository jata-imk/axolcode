<?php

namespace App\Models\PaginasWeb;

use App\Models\RedesSociales\RedSocial;
use Illuminate\Database\Eloquent\Model;

class PaginaWeb extends Model
{
    protected $table = 'paginas_web';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'pagina_web',
        'facebook',
        'instagram',
        'twitter',
        'pinterest',
        'tripadvisor',
        'youtube',
        'linkedin',
        'tiktok',
        'google',
        'logo_web',
        'whatsapp',
        'telefono',
        'footer_copyright',
        'politicas',
        'aviso_privacidad',
        'snippet_header',
        'snippet_footer',
        'snippet_reviews'
    ];

    /**
     * Obtiene las redes sociales de la pagina web
     */
    public function redesSociales()
    {
        return $this->belongsToMany(RedSocial::class, 'paginas_web_redes_sociales', 'id_pagina_web', 'id_red_social')
            ->withPivot('url');
    }
}
