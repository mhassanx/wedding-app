<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestLinkController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RsvpController;
use App\Http\Middleware\GuestListAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvitationController::class, 'show'])->name('home');

Route::get('/invite/{code}', [InvitationController::class, 'showForGuest'])->name('invite.show');

Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');

Route::middleware(GuestListAuth::class)->group(function () {
    Route::get('/guest-list', [RsvpController::class, 'index'])->name('rsvp.index');

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/admin/guests', [GuestLinkController::class, 'store'])->name('admin.guests.store');
    Route::delete('/admin/guests/{guest}', [GuestLinkController::class, 'destroy'])->name('admin.guests.destroy');

    Route::get('/admin/settings', [AdminController::class, 'editSettings'])->name('admin.settings.edit');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    Route::get('/admin/gallery', [AdminController::class, 'gallery'])->name('admin.gallery');
    Route::post('/admin/gallery', [AdminController::class, 'uploadGalleryImage'])->name('admin.gallery.upload');
    Route::delete('/admin/gallery/{image}', [AdminController::class, 'deleteGalleryImage'])->name('admin.gallery.delete');
});
