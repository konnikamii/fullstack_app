<?php

use App\Http\Controllers\ContactController;
use App\Http\Resources\ContactsResource;
use App\Http\Resources\UserResource;
use App\Models\Contacts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function () {
    return UserResource::collection(resource: User::all());
});
Route::get('/csrf-token', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('/contacts', function () {
    return ContactsResource::collection(resource: Contacts::all());
});
Route::post('/contacts', [ContactController::class, 'store']);
