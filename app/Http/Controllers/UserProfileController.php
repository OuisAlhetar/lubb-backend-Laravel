<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserProfileController extends Controller
{
    /**
     * Get full profile data (user info, liked items, saved items).
     */
    public function getFullProfile()
    {
        $user = Auth::user();
        $cacheKey = 'user_profile_' . $user->id;

        // Try retrieving from cache
        $profileData = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user) {
            // Fetch liked items
            $likedItems = $user->likes()->with('item')->get()->pluck('item');

            // Fetch saved items
            $savedItems = $user->saves()->with('item')->get()->pluck('item');

            return [
                'user' => $user,
                'liked_items' => $likedItems,
                'saved_items' => $savedItems
            ];
        });

        return response()->json($profileData, 200);
    }

    /**
     * Update user profile information.
     */
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

        // Clear cached profile data
        Cache::forget('user_profile_' . $user->id);

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    /**
     * Unsave an item.
     */
    public function unsaveItem($itemId)
    {
        $user = Auth::user();
        $savedItem = Save::where('user_id', $user->id)->where('item_id', $itemId)->first();

        if ($savedItem) {
            $savedItem->delete();

            // Clear cached profile data
            Cache::forget('user_profile_' . $user->id);
            Cache::forget('item_' . $itemId);

            return response()->json(['message' => 'Item unsaved successfully'], 200);
        }

        return response()->json(['message' => 'Item not found in saved items'], 404);
    }

    /**
     * Unlike an item.
     */
    public function unlikeItem($itemId)
    {
        $user = Auth::user();
        $likedItem = Like::where('user_id', $user->id)->where('item_id', $itemId)->first();

        if ($likedItem) {
            $likedItem->delete();

            // Clear cached profile data
            Cache::forget('user_profile_' . $user->id);
            Cache::forget('item_' . $itemId);

            return response()->json(['message' => 'Item unliked successfully'], 200);
        }

        return response()->json(['message' => 'Item not found in liked items'], 404);
    }
}
