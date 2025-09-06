<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes for dynamic data fetching
Route::middleware('auth')->group(function () {
    // Company-related data
    Route::get('/companies/{company}/contacts', function (Company $company) {
        return $company->contacts()->get(['id', 'first_name', 'last_name']);
    });
    
    Route::get('/companies/{company}/deals', function (Company $company) {
        return $company->deals()->get(['id', 'name']);
    });
    
    // Contact data
    Route::get('/contacts/{contact}', function (Contact $contact) {
        return $contact->load('company:id,name');
    });
    
    // Deal stage updates (for kanban drag & drop)
    Route::patch('/deals/{deal}/update-stage', function (Request $request, Deal $deal) {
        $request->validate([
            'deal_stage_id' => 'required|exists:deal_stages,id'
        ]);
        
        $deal->update([
            'deal_stage_id' => $request->deal_stage_id
        ]);
        
        return response()->json(['success' => true]);
    });
});
