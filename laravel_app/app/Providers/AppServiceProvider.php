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
                    'icon' => 'dashboard',
                ],
                [
                    'name' => translate('Konten'),
                    'url' => '/admin/contents',
                    'icon' => 'cube',
                ],
                [
                    'name' => translate('Kelola User'),
                    'url' => '/admin/users',
                    'icon' => 'users',
                ],
                [
                    'name' => translate('Pengaturan'),
                    'url' => '/admin/setting',
                    'icon' => 'settings',
                ],
            ];
            $view->with('menus', $menus);
        });

        // View Composer for User Navigation
        \Illuminate\Support\Facades\View::composer('components.navigation-users', function ($view) {
            $menus = [
                [
                    'name' => 'Dashboard',
                    'url' => '/users/dashboard',
                    'icon' => 'dashboard',
                ],
                [
                    'name' => translate('Kelola Foto'),
                    'url' => '/users/foto',
                    'icon' => 'photo',
                ],
                [
                    'name' => translate('Kelola Lokasi'),
                    'url' => '/users/lokasi',
                    'icon' => 'location',
                ],
                [
                    'name' => translate('Kelola Toko'),
                    'url' => '/users/toko',
                    'icon' => 'store',
                ],
                [
                    'name' => translate('Pengaturan'),
                    'url' => '/users/setting',
                    'icon' => 'settings',
                ],
            ];
            $view->with('menus', $menus);
        });
    }
}
