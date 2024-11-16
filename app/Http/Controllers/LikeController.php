<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeItem(Request $request, $itemId)
    {
        $like = Like::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ]);

        return response()->json(['liked' => true, 'like' => $like]);
    }

    public function unlikeItem(Request $request, $itemId)
    {
        Like::where([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ])->delete();

        return response()->json(['liked' => false]);
    }

}