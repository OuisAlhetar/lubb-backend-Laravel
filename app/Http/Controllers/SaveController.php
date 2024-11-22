<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SaveController extends Controller
{
    public function saveItem(Request $request, $itemId)
    {
        $save = Save::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ]);

        // Clear cached profile data
        Cache::forget('user_profile_' . $request->user()->id);
        Cache::forget("item_{$itemId}");
        Cache::forget("user_{$request->user()->id}_item_{$itemId}_states");

        return response()->json(['saved' => true, 'save' => $save]);
    }

    public function unsaveItem(Request $request, $itemId)
    {
        Save::where([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ])->delete();

        // Clear cached profile data
        Cache::forget('user_profile_' . $request->user()->id);
        Cache::forget("item_{$itemId}");
        Cache::forget("user_{$request->user()->id}_item_{$itemId}_states");


        
        return response()->json(['saved' => false]);
    }

}