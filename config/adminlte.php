<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SICE',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SICE',
    'use_ico_only' => true,
    'use_full_favicon' => true,


    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Eduma</b>TICS',
    'logo_img' => 'vendor/adminlte/dist/img/logo.jpeg',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Eduma</b>TICS',
    'logo_img' => 'vendor/adminlte/dist/img/logo.jpeg',
    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/logo.jpeg',
            'width' => 160,
            'height' => 160,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/logo.jpeg',
            'effect' => 'animation__shake',
            'width' => 100,
            'height' => 100,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-success',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_boxed' => false, // Asegura que el layout no esté en modo 'boxed'
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,


    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'bg-light text-dark min-vh-100',
    'classes_brand' => 'bg-gradient-success border border-success shadow-lg',
    'classes_brand_text' => 'text-light',
    'classes_content_wrapper' => 'p-3 bg-white shadow-sm',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-white elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'bg-gradient-success border border-success shadow-lg navbar-dark text-white',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => true,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => true,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'profile.edit',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'header' => 'INICIO'
        ],
        [
            'text' => 'Dashboard',
            'url' => 'dashboard',
            'icon' => 'fas fa-fw fa-home',
            'icon_color' => 'success'
        ],
        [
            'header' => 'ADMINISTRADOR'
        ],
        [
            'text' => 'Roles y permisos',
            'icon' => 'fas fa-fw fa-wrench',
            'submenu' => [
                [
                    'text' => 'Roles',
                    'url'  => 'roles',
                    'icon' => 'fas fa-fw fa-users-cog',
                    'can'  => 'roles.index',
                ],
                [
                    'text' => 'Permisos',
                    'url'  => 'permissions',
                    'icon' => 'fas fa-fw fa-user-cog',
                    'can'  => 'permissions.index',
                ],
                [
                    'text'        => 'users',
                    'url'         => 'users',
                    'icon'        => 'fas fa-fw fa-users',
                    'can'         => 'users.index',
                ],
            ]
        ],
        [
            'text' => 'Admistrativos',
            'icon' => 'fas fa-fw fa-user-tie',
            'icon_color' => 'info',
            'submenu' => [
                [
                    'text' => 'Evaluadores',
                    'icon' => 'fas fa-fw fa-user-shield',
                    'icon_color' => 'primary',
                    'submenu' => [
                        [
                            'text' => 'Agrega tus evaluadores',
                            'url' => 'evaluadores',
                            'icon' => 'fas fa-fw fa-user-plus',
                            'icon_color' => 'success',

                        ],
                        [
                            'text' => 'Asigna Evaluadores',
                            'url' => 'asignar-evaluadores',
                            'icon' => 'fas fa-fw fa-user-check',
                            'icon_color' => 'success',
                        ],
                    ],
                ],
                [
                    'text' => 'Expedientes',
                    'icon' => 'fas fa-fw fa-folder',
                    'icon_color' => 'primary',
                    'submenu' => [
                        [
                            'text' => 'Lista de expedientes',
                            'url' => 'usuariosAdmin',
                            'icon' => 'fas fa-archive',
                            'icon_color' => 'success',
                        ],
                    ],
                ],
                [
                    'text' => 'Competencias y Cursos',
                    'icon' => 'fas fa-fw fa-book',
                    'icon_color' => 'primary',
                    'submenu' => [

                        [
                            'text' => 'Registrar de cursos',
                            'url' => 'cursos',
                            'icon' => 'fas fa-plus-circle',
                            'icon_color' => 'success',
                        ],
                        [
                            'text' => 'Registro de estandares',
                            'url' => 'competenciasAD',
                            'icon' => 'fas fa-tasks',
                            'icon_color' => 'success',
                        ],
                        [
                            'text' => 'Registro de Documentos Necesarios',
                            'url' => 'documentosnec',
                            'icon' => 'fas fa-file-alt',
                            'icon_color' => 'success',
                        ],
                        [
                            'text' => 'Agregar diagnosticos',
                            'url' => 'diagnosticos',
                            'icon' => 'fas fa-fw fa-file-invoice',
                        ],
                        [
                            'text' => 'Regitro de diagnosticos',
                            'url' => '',
                            'icon' => 'fas fa-fw fa-file-invoice',
                            'icon_color' => 'success',
                        ],
                    ],
                ],
                [
                    'text' => 'Códigos Postales',
                    'icon' => 'fas fa-fw fa-envelope',
                    'icon_color' => 'primary',
                    'submenu' => [
                        [
                            'text' => 'Agregar Códigos Postales',
                            'url' => 'codigos-postales',
                            'icon' => 'fas fa-fw fa-paper-plane',
                            'icon_color' => 'success',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'icon_color' => 'info',
            'submenu' => [
                [
                    'text' => 'Inicio',
                    'url' => 'usuarios',
                    'icon' => 'fas fa-fw fa-columns',
                    'icon_color' => 'orange',
                ],
                [
                    'text' => 'Mis cursos',
                    'url' => 'misCursos',
                    'icon' => 'fas fa-fw fa-chalkboard',
                    'icon_color' => 'purple',
                ],
                [
                    'text' => 'Mis Competencias',
                    'url' => 'miscompetencias',
                    'icon' => 'fas fa-fw fa-clipboard-check',
                    'icon_color' => 'teal',
                ]
            ]
        ],
        [
            'text' => 'Ajustes',
            'icon' => 'fas fa-fw fa-id-badge',
            'icon_color' => 'info',
            'submenu' => [
                [
                    'text' => 'Perfil',
                    'url' => 'profile',
                    'icon' => 'fas fa-fw fa-user',
                    'icon_color' => 'indigo',
                ],
                [
                    'text' => 'change_password',
                    'url' => 'admin/settings',
                    'icon' => 'fas fa-fw fa-lock',
                    'icon_color' => 'danger',

                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'FontAwesome' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/fontawesome-free/css/all.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
