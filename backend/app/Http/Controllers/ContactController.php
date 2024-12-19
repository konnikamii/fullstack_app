<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactsRequest;
use App\Http\Resources\ContactsResource;
use App\Models\Contacts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log; 
 

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */ 
     public function store(StoreContactsRequest $request): JsonResponse 
     { 
        // return new ContactsResource(Contacts::create($request->all()));
         try {
             // Validate the request data
             $validatedData = $request->validate([
                 'name' => 'required|string|max:255',
                 'email' => 'required|email|max:255',
                 'subject' => 'required|string|max:255',
                 'message' => 'required|string|max:1500',
             ]);
             Log::debug('Validated Data:', ['name' => $validatedData['name']]);
 
             // Handle the form submission
             $contact = Contacts::create($validatedData); 
             Log::debug('Contact Created:', ['id' => $contact->id, 'name' => $contact->name]);
 
             // Send a raw email using the Mail facade
             Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
                 $message->to('test@mailhog.local')
                         ->subject($validatedData['subject'])
                         ->from($validatedData['email'], $validatedData['name']);
             });
             Log::debug('Email Sent to test@mailhog.local');
 
 
             // Return a JSON response with the saved data
             return response()->json( ['success' => true],201 );
         } catch (ValidationException $e) {
             Log::error('Validation Errors:', $e->errors());
             // Return a JSON response with validation errors
             return response()->json( ['success' => false, 'errors' =>$e->errors()] , 422);
         }
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
