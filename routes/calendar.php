<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AgendaItemController;
use App\Http\Controllers\FilterController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendaItemReminder;

Route::get('/', function () {
    return redirect('/calendar');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/calendar', CalendarController::class)
    ->middleware('auth');

Route::resource('/agenda-items', AgendaItemController::class)
    ->middleware('auth');

Route::get('/view-email-agendaitem', function () {
    $agendaItem = App\Models\AgendaItem::find(6);
    return  new AgendaItemReminder($agendaItem);
});

Route::resource('/manage-filters', FilterController::class)
    ->middleware('auth');
