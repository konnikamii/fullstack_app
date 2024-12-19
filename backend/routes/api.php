<?php

use App\Http\Resources\UserResource;
use App\Http\Resources\ContactsResource;
use App\Http\Controllers\ContactController;
use App\Models\User;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/csrf-token', function (Request $request) {
//     return response()->json(['csrf_token' => csrf_token()]);
// });

Route::get("/users", function () {
    return UserResource::collection(resource: User::all());
});
Route::get("/contacts", function () {
    return ContactsResource::collection(resource: Contacts::all());
});
// Route::middleware('CORSMiddleware')->group(function () {
// Route::post('/contacts', [ContactController::class, 'store']);
// });

// Route::middleware('CorsMiddleware')->group(function () {
Route::get('/csrf-token', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('/contacts', [ContactController::class, 'store']);
// });