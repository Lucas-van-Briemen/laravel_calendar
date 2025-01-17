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
    $agendaItems = AgendaItem::where('start', '<=', now()->addMinutes(30))
        ->where('start', '>=', now())
        ->get();

        $this->info('Found ' . $agendaItems->count() . ' agenda items');
})->everyMinute();
