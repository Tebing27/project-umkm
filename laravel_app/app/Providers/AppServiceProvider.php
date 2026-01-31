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
        // Fix for Key Too Long error on older MySQL/MariaDB (Shared Hosting)
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        // Register Firebase Listeners
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ContentUpdated::class,
            \App\Listeners\PushToFirebase::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ShopUpdated::class,
            \App\Listeners\PushToFirebase::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ProductUpdated::class,
            \App\Listeners\PushToFirebase::class
        );
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
            ['components.navigation', 'components.navigation-umkm'],
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
                    'active_routes' => ['users/toko*', 'users/edit-toko*'],
                ],
                [
                    'name' => translate('Pengaturan'),
                    'url' => '/users/setting',
                    'icon' => 'ui-settings',
                ],
            ];
            $view->with('menus', $menus);
        });

        // View Composer for Footer
        \Illuminate\Support\Facades\View::composer('components.footer', function ($view) {
            $content = \App\Models\Content::whereIn('group', ['footer', 'logo'])->get()->keyBy('key');
            $view->with('content', $content);
        });




        // Custom Verify Email Notification
        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Verifikasi Alamat Email Anda - UMKM Sasuma')
                ->view('emails.verify-email', ['url' => $url, 'user' => $notifiable]);
        });

        // Custom Reset Password Notification
        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Reset Password - UMKM Sasuma')
                ->view('emails.reset-password', ['url' => $url, 'user' => $notifiable]);
        });
    }
}
