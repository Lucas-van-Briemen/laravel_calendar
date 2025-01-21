<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\AgendaItem;
use App\Mail\AgendaItemReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Send an email if an agenda item is in 30 minutes
Artisan::command('agenda-item-reminder', function () {
    // Get all agenda items that are in 30 minutes
    $agendaItems = AgendaItem::where('start', '<=', now()->addMinutes(90))
        ->whereBetween('should_send_at', [
            now()->addMinutes(-30)->format('Y-m-d H:i:s'),
            now()->addMinutes(90)->format('Y-m-d H:i:s')
        ])
        ->get();

    $this->info('Found ' . $agendaItems->count() . ' agenda items');

    // Send an email to the user
    foreach ($agendaItems as $agendaItem) {
        $userID = $agendaItem->user_id;

        // Get the email associated with the user
        $user = User::find($userID);
        $email = $user->email;

        Mail::to($email)->send(new AgendaItemReminder($agendaItem));

        // Calculate the next time to send the email (if repeat is not "never")
        if ($agendaItem->repeating == 'never') {
            // Delete the agenda item
            $agendaItem->should_send_at = null;
        }

        if ($agendaItem->repeating == 'daily') {
            // Add 1 day to the should_send_at
            $agendaItem->should_send_at = Carbon::parse($agendaItem->should_send_at)->addDay();
        }

        if ($agendaItem->repeating == 'weekdays') {
            // Add 1 day to the should_send_at
            $agendaItem->should_send_at = Carbon::parse($agendaItem->should_send_at)->addWeekday();
        }

        if ($agendaItem->repeating == 'weekly') {
            // Add 1 week to the should_send_at
            $agendaItem->should_send_at = Carbon::parse($agendaItem->should_send_at)->addWeek();
        }

        if ($agendaItem->repeating == 'monthly') {
            // Add 1 month to the should_send_at
            $agendaItem->should_send_at = Carbon::parse($agendaItem->should_send_at)->addMonth();
        }

        if ($agendaItem->repeating == 'yearly') {
            // Add 1 year to the should_send_at
            $agendaItem->should_send_at = Carbon::parse($agendaItem->should_send_at)->addYear();
        }

        $agendaItem->save();
    }

    $this->info('Emails sent');
})->everyMinute();
