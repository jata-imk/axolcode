<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

use App\Models\Menus\Menu;

class Rol extends Model
{
    protected $table = 'roles';

    /**
     * The menus that belong to the role.
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'roles_menus', 'id_rol', 'id_menu');
    }
}
