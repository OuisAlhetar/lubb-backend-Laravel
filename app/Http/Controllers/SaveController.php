<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function saveItem(Request $request, $itemId)
    {
        $save = Save::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ]);

        return response()->json(['saved' => true, 'save' => $save]);
    }

    public function unsaveItem(Request $request, $itemId)
    {
        Save::where([
            'user_id' => $request->user()->id,
            'item_id' => $itemId,
        ])->delete();

        return response()->json(['saved' => false]);
    }

}