<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    // Show user profile information
    // public function show()
    // {
    //     $user = Auth::user();
    //     return response()->json($user, 200);
    // }

    public function getFullProfile()
    {
        $user = Auth::user();

        // Fetch liked items
        $likedItems = $user->likes()->with('item')->get()->pluck('item');

        // Fetch saved items
        $savedItems = $user->saves()->with('item')->get()->pluck('item');

        // Return all data in a single response
        return response()->json([
            'user' => $user,
            'liked_items' => $likedItems,
            'saved_items' => $savedItems
        ], 200);
    }

    
    // Update user profile information
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:8|confirmed'
        ]);

        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    // // Show saved items
    // public function showSavedItems()
    // {
    //     $user = Auth::user();
    //     $savedItems = $user->saves()->with('item')->get()->pluck('item');
    //     return response()->json($savedItems, 200);
    // }

    // // Show liked items
    // public function showLikedItems()
    // {
    //     $user = Auth::user();
    //     $likedItems = $user->likes()->with('item')->get()->pluck('item');
    //     return response()->json($likedItems, 200);
    // }

    // Unsave an item
    public function unsaveItem($itemId)
    {
        $user = Auth::user();
        $savedItem = Save::where('user_id', $user->id)->where('item_id', $itemId)->first();

        if ($savedItem) {
            $savedItem->delete();
            return response()->json(['message' => 'Item unsaved successfully'], 200);
        }

        return response()->json(['message' => 'Item not found in saved items'], 404);
    }

    // Unlike an item
    public function unlikeItem($itemId)
    {
        $user = Auth::user();
        $likedItem = Like::where('user_id', $user->id)->where('item_id', $itemId)->first();

        if ($likedItem) {
            $likedItem->delete();
            return response()->json(['message' => 'Item unliked successfully'], 200);
        }

        return response()->json(['message' => 'Item not found in liked items'], 404);
    }
}