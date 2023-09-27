<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GuideResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuideController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'showPublic']);
    }
    
    /**
     * Display a listing of the resource.
     */
    // get data for user_type = guide
    public function index()
    {
        $guides = User::where('reviewer', 'guide')->get();
        return GuideResource::collection($guides);
    }

    public function showPublic(User $guide)
    {
        // user_type = guide & get loged in guides's data
        if(!$guide->isGuide()) {
            return response()->json(['error' => 'You are not a guide'], 403);
        }

        return new GuideResource($guide);
    }

    /**
     * Display the specified resource.
     */

    public function showPrivate(User $guide)
    {
        // user_type = guide & load logged in guide's reviews and bookings
        if(!$guide->isGuide()) {
            return response()->json(['error' => 'You are not a guide'], 403);
        }

        $guide->load(['reviews', 'bookings']);

        return new GuideResource($guide);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

}
