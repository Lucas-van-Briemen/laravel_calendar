<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AgendaItemController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendaItemReminder;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::get('/database-layout', function () {
    return view('database-layout');
});

require __DIR__.'/auth.php';
