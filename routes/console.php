<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\AgendaItem;
use App\Mail\AgendaItemReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Send an email if an agenda item is in 30 minutes
Artisan::command('agenda-item-reminder', function () {
    // Get all agenda items that are in 30 minutes
    $agendaItems = AgendaItem::where('start', '<=', now()->addMinutes(90))
        ->where('start', '>=', now()->addMinutes(60))
        ->get();

    $this->info('Found ' . $agendaItems->count() . ' agenda items that start between: ' . now()->addMinutes(30))->format('Y-m-d H:i:s')) . ' and ' . now()->addMinutes(90)->format('Y-m-d H:i:s');

    // Send an email to the user
    foreach ($agendaItems as $agendaItem) {
        $userID = $agendaItem->user_id;

        // Get the email associated with the user
        $user = User::find($userID);
        $email = $user->email;

        Mail::to($email)->send(new AgendaItemReminder($agendaItem));
    }

    $this->info('Emails sent');
})->everyMinute();
