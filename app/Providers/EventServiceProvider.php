<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Event;

use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use Illuminate\Support\Facades\Auth;
use App\Models\Menus\Menu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {            
            $menus = null;

            if ((Auth::user()->rol->id === 0) || (Auth::user()->rol->nombre === "Administrador")) {
                $menus = Menu::where("menus.active", "=", 1)
                    ->orderBy("menus.key", "desc")
                    ->orderBy("menus.id", "asc")
                    ->select()
                    ->get();
            } else {
                $menus = Auth::user()->rol->menus()
                    ->where("roles_menus.ver", "=", 1)
                    ->where("menus.active", "=", 1)
                    ->orderBy("menus.key", "desc")
                    ->orderBy("menus.id", "asc")
                    ->get();
            }

            $seccionesMenus = [];

            foreach ($menus as $menu) {
                $seccionesMenus[$menu->section][] = $menu;
            }

            foreach ($seccionesMenus as $nombreSeccion => $menusSeccion) {
                $event->menu->add($nombreSeccion);

                foreach ($menusSeccion as $menu) {
                    if ($menu->add_in === "") {
                        if ($menu->key === "") {
                            $event->menu->add([
                                'text'          => $menu->text,
                                'icon'          => $menu->icon,
                                'url'           => $menu->url,
                                'icon_color'    => $menu->icon_color,
                            ]);
                        } else {
                            $event->menu->add([
                                'text'          => $menu->text,
                                'icon'          => $menu->icon,
                                'key'           => $menu->key,
                                'icon_color'    => $menu->icon_color,
                            ]);
                        }
                    } else {
                        $event->menu->addIn($menu->add_in, [
                            'text'          => $menu->text,
                            'icon'          => $menu->icon,
                            'url'           => $menu->url,
                            'icon_color'    => $menu->icon_color,
                        ]);
                    }
                }
            }

            if (Auth::user()->rol->id === 0) {
                $event->menu->add('SUPERADMIN');

                $event->menu->add([
                    'text'  => 'Empresas',
                    'icon'  => 'fas fa-fw fa-globe',
                    'url'   => 'admin/empresas',
                    'icon_color' => ""
                ]);

                $event->menu->add([
                    'text'  => 'Modulos',
                    'icon'  => 'fas fa-layer-group',
                    'url'   => 'admin/modulos',
                    'icon_color' => ""
                ]);

                $event->menu->add([
                    'text'  => 'Terminales',
                    'icon'  => 'fas fa-credit-card',
                    'url'   => 'admin/terminales',
                    'icon_color' => ""
                ]);

                $event->menu->add([
                    'text'  => 'Formas de pago',
                    'icon'  => 'fas fa-money-check-alt',
                    'url'   => 'admin/formaspago',
                    'icon_color' => ""
                ]);
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
