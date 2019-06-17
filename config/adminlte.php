<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    */

    'title' => 'Stock Manager',
    'logo' => 'nada',
    'userPic' => './img/customer-support.png',
    'username' => '',

    /*
    |--------------------------------------------------------------------------
    | Navbar skin
    |--------------------------------------------------------------------------
    |   Cambia el look&feel de la plantilla, el 'tema'
    |   los disponibles son: 
    |   - bg- : primary, info, danger, success, warning, white, light
    |   - navbar-: light, dark
    |   - border: 'border-bottom'
    */
    
    'navbar-bg' => 'light',
    'navbar-color' => 'light',
    'navbar-border' => 'border-bottom',
    'brand-logo' => '',


    /*
    |--------------------------------------------------------------------------
    | Left navbar
    |--------------------------------------------------------------------------
    |
    |   Links en la parte superior izquierda, parametros: text, url, icon
    |   
    */

    'left-navbar' => [
        'LEFT NAVBAR',
        [
            'text' => 'Home',
            'url'  => '/',
        ],
        [
            'text'        => 'Contact',
            'url'         => 'home',
            'icon'        => '',
        ],
        

    ],

    /*
    |--------------------------------------------------------------------------
    | MENU
    |--------------------------------------------------------------------------
    |   Menu principal, parametros: text, url, badge, badge_color,
    |   icon, icon_color, (ver 'can')
    */

    'menu' => [
        'MAIN NAVIGATION',
        [
            'text' => 'Materiales',
            'can'  => 'manage-blog',
            'icon' => 'box-open',
            'submenu' => [
                [
                    'text' => 'Calendario',
                    'url'  => '/calendario',
                    'icon' => 'calendar',
                ],
                [
                    'text' => 'Agregar Consumo',
                    'url'  => '/consumo',
                    'icon' => 'plus',
                ],
            ],
        ],
        [
            'text'        => 'Administración',
            'url'         => '/home',
            'icon'        => 'file',
            'submenu' => [
                [
                    'text' => 'Agregar Materiales',
                    'url'  => '/materiales',
                    'icon' => 'plus',
                ],[

                    'text' => 'Agregar Contratistas',
                    'url'  => '/contratistas',
                    'icon' => 'industry',
                ],
            ],
        ],
        
        'ACCOUNT SETTINGS',
        [
            'text' => 'Perfil usuario',
            'url'  => 'admin/settings',
            'icon' => 'user',
        ],
        [
            'text' => 'Cambiar Contraseña',
            'url'  => 'admin/settings',
            'icon' => 'lock',
        ],
        [
            'text'    => 'User Lab',
            'icon'    => 'share',
            'submenu' => [
                [
                    'text' => 'Crear Usuario',
                    'url'  => '/register',
                    'icon' =>'user-plus',
                ],
                [
                    'text' => 'Lista de Usuarios',
                    'url'  => '/user',
                    'icon' => 'address-card',
                ],

               /* [
                    'text'    => 'Level One',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'Level Two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'Level Two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                    'badge' => 'New',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],*/
            ],
        ],
        '-',
        [
            'text'       => 'Important',
            'icon_color' => 'primary',
            'badge' => 'New',
        ],
        [
            'text'       => 'Warning',
            'icon_color' => 'warning',
        ],
        [
            'text'       => 'Information',
            'icon_color' => 'danger',
        ],
    ],
    
    


    

];