<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\AgendaItem;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Send an email if an agenda item is in 30 minutes
Artisan::command('agenda-item-reminder', function () {
    // Get all agenda items that are in 30 minutes
    $agendaItems = AgendaItem::where('start', '<=', now()->addMinutes(90))
        ->where('start', '>=', now()->addMinutes(60))
        ->get();

        $this->info('Found ' . $agendaItems->count() . ' agenda items that start between: ' . now()->format('Y-m-d H:i:s')) . ' and ' . now()->addMinutes(30)->format('Y-m-d H:i:s');
})->everyMinute();
