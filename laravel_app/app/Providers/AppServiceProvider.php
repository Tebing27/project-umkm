<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer for Admin Navigation
        \Illuminate\Support\Facades\View::composer('components.navigation-admin', function ($view) {
            $menus = [
                [
                    'name' => 'Dashboard',
                    'url' => '/admin/dashboard',
                    'icon' => 'nav-dashboard',
                ],
                [
                    'name' => translate('Konten'),
                    'url' => '/admin/contents',
                    'icon' => 'data-product',
                ],
                [
                    'name' => translate('Kelola User'),
                    'url' => '/admin/users',
                    'icon' => 'data-users',
                ],
                [
                    'name' => translate('Pengaturan'),
                    'url' => '/admin/setting',
                    'icon' => 'ui-settings',
                ],
            ];
            $view->with('menus', $menus);
        });

        // View Composer for Public Navigation (Logo data)
        \Illuminate\Support\Facades\View::composer(
            'components.navigation',
            \App\View\Composers\NavigationComposer::class
        );

        // View Composer for User Navigation
        \Illuminate\Support\Facades\View::composer('components.navigation-users', function ($view) {
            $menus = [
                [
                    'name' => 'Dashboard',
                    'url' => '/users/dashboard',
                    'icon' => 'nav-dashboard',
                ],
                [
                    'name' => translate('Kelola Foto'),
                    'url' => '/users/foto',
                    'icon' => 'data-photo',
                ],
                [
                    'name' => translate('Kelola Lokasi'),
                    'url' => '/users/lokasi',
                    'icon' => 'map-pin',
                ],
                [
                    'name' => translate('Kelola Toko'),
                    'url' => '/users/toko',
                    'icon' => 'data-store',
                ],
                [
                    'name' => translate('Pengaturan'),
                    'url' => '/users/setting',
                    'icon' => 'ui-settings',
                ],
            ];
            $view->with('menus', $menus);
        });
    }
}
