<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', function() { return redirect()->route('dashboard'); });

    // Companies
    Route::resource('companies', CompanyController::class);

    // Contacts
    Route::resource('contacts', ContactController::class);

    // Leads
    Route::resource('leads', LeadController::class);
    Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');

    // Deals
    Route::resource('deals', DealController::class);
    Route::post('deals/{deal}/won', [DealController::class, 'markAsWon'])->name('deals.won');
    Route::post('deals/{deal}/lost', [DealController::class, 'markAsLost'])->name('deals.lost');

    // Activities
    Route::resource('activities', ActivityController::class);
    Route::post('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');

    // Email Campaigns
    Route::resource('email-campaigns', EmailCampaignController::class);
    Route::post('email-campaigns/{emailCampaign}/send', [EmailCampaignController::class, 'send'])->name('email-campaigns.send');
    Route::post('email-campaigns/{emailCampaign}/schedule', [EmailCampaignController::class, 'schedule'])->name('email-campaigns.schedule');

    // Products
    Route::resource('products', ProductController::class);

    // API Routes for Select2 and other AJAX requests
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('companies/search', [CompanyController::class, 'search'])->name('companies.search');
        Route::get('contacts/search', [ContactController::class, 'search'])->name('contacts.search');
        Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    });
});
