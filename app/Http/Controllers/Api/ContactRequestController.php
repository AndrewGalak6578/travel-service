<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable','string','max:255'],
            'email' => ['required','email','max:255'],
            'message' => ['required','string'],
        ]);

        $cr = ContactRequest::create($data);

        return response()->json(['ok' => true, 'id' => $cr->id], 201);
    }
}
