<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $q = Destination::query();

        if ($request->filled('region')) {
            $q->where('region', $request->string('region'));
        }
        if ($request->filled('experience_type')) {
            $q->where('experience_type', $request->string('experience_type'));
        }

        return $q->orderBy('name')->get();
    }

    public function show(Destination $destination)
    {
        return $destination;
    }
}
