<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GuestResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
     public function __construct(){
        $this->middleware('auth:sanctum')->except(['index', 'showPublic']);
     }

    /**
     * Display the specified resource.
     */
    public function showPublic(User $guest)
    {
        // user_type = guest & get loged in guest's data
        if(!$guest->isGuest()) {
            return response()->json(['error' => 'You are not a guest'], 403);
        }

        return new GuestResource($guest);
    }

    /**
     * Display the specified resource.
     */
    public function showPrivate(User $guest)
    {
        // user_type = guest & load logged in guest's reviews and bookings
        if(!$guest->isGuest()) {
            return response()->json(['error' => 'You are not a guest'], 403);
        }

        $guest->load(['reviews', 'bookings']);

        return new GuestResource($guest);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

}
