<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactsRequest;
use App\Models\Contacts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{  
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactsRequest $request): JsonResponse
    {
        try {
            // Validate the request data
            $validatedData = $request->validated();
            Log::debug('Validated Data:', ['name' => $validatedData['name']]);

            // Handle the form submission
            $contact = Contacts::create($validatedData);
            Log::debug('Contact Created:', ['id' => $contact->id, 'name' => $contact->name]);

            // Send a raw email using the Mail facade
            try {
                Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
                    $message->to('test@mailhog.local')
                        ->subject($validatedData['subject'])
                        ->from($validatedData['email'], $validatedData['name']);
                });
                Log::debug('Email Sent to test@mailhog.local');
            } catch (\Exception $e) {
                Log::error('Failed to send email:', ['error' => $e->getMessage()]);
            }

            // Return a JSON response with the saved data
            return response()->json(['success' => true], 201);
        } catch (ValidationException $e) {
            Log::error('Validation Errors:', $e->errors());

            // Return a JSON response with validation errors
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }
}
