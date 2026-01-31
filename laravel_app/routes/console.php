<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule sitemap generation to run daily at 2:00 AM
Schedule::command('sitemap:generate')->dailyAt('02:00');

// Clean old translations (optional, weekly)
Schedule::command('translations:clean')->weeklyOn(0, '03:00');
