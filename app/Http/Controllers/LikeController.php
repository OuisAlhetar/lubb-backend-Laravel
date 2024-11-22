<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LikeController extends Controller
{
    public function likeItem(Request $request, $itemId)
    {
        $like = Like::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ]);

        // Clear cached profile data
        Cache::forget('user_profile_' . $request->user()->id);
        Cache::forget("item_{$itemId}");
        Cache::forget("user_{$request->user()->id}_item_{$itemId}_states");

        return response()->json(['liked' => true, 'like' => $like]);
    }

    public function unlikeItem(Request $request, $itemId)
    {
        Like::where([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ])->delete();

        // Invalidate the cache for this item's states
        Cache::forget('user_profile_' . $request->user()->id);
        Cache::forget("item_{$itemId}");
        Cache::forget("user_{$request->user()->id}_item_{$itemId}_states");
        

        return response()->json(['liked' => false]);
    }

}
