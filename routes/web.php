<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
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
    Route::get('leads/{lead}/convert', [LeadController::class, 'showConvertForm'])->name('leads.convert.form');
    Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');

    // Deals
    Route::resource('deals', DealController::class);
    Route::get('deals-pipeline', [DealController::class, 'pipeline'])->name('deals.pipeline');
    Route::post('deals/{deal}/won', [DealController::class, 'markAsWon'])->name('deals.won');
    Route::post('deals/{deal}/lost', [DealController::class, 'markAsLost'])->name('deals.lost');
    Route::patch('deals/{deal}/stage', [DealController::class, 'updateStage'])->name('deals.update-stage');

    // Activities
    Route::resource('activities', ActivityController::class);
    Route::post('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
    Route::get('activities-calendar', [ActivityController::class, 'calendar'])->name('activities.calendar');

    // Email Campaigns
    Route::resource('email-campaigns', EmailCampaignController::class);
    Route::post('email-campaigns/{emailCampaign}/send', [EmailCampaignController::class, 'send'])->name('email-campaigns.send');
    Route::post('email-campaigns/{emailCampaign}/schedule', [EmailCampaignController::class, 'schedule'])->name('email-campaigns.schedule');

    // Products
    Route::resource('products', ProductController::class);

    // Quotes
    Route::resource('quotes', QuoteController::class);
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'generatePdf'])->name('quotes.pdf');
    Route::post('quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
    Route::post('quotes/{quote}/accept', [QuoteController::class, 'accept'])->name('quotes.accept');
    Route::post('quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject');
    Route::post('quotes/{quote}/duplicate', [QuoteController::class, 'duplicate'])->name('quotes.duplicate');

    // API Routes for Select2 and other AJAX requests
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('companies/search', [CompanyController::class, 'search'])->name('companies.search');
        Route::get('contacts/search', [ContactController::class, 'search'])->name('contacts.search');
        Route::get('products/search', [ProductController::class, 'getProductsJson'])->name('products.search');
        Route::get('users/search', function() {
            $users = \App\Models\User::select('id', 'name as text')->get();
            return response()->json($users);
        })->name('users.search');
    });
});
