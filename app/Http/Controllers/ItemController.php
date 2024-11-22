<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MostViewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller
{
    /**
     * Display a listing of the items, with optional filters for section, category, and tags.
     */
    public function index(Request $request)
    {
        $cacheKey = 'items_' . md5(json_encode($request->all()));

        // Retrieve cached data or execute the query and cache it
        $items = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            $query = Item::query();

            // Apply filters as usual
            if ($request->has('search') && $request->search) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('short_summary', 'like', '%' . $request->search . '%');
            }
            if ($request->has('section_id') && $request->section_id) {
                $query->where('section_id', $request->section_id);
            }
            if ($request->has('category_id') && $request->category_id) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category_id);
                });
            }
            if ($request->has('tag_id') && $request->tag_id) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('tags.id', $request->tag_id);
                });
            }

            return $query->paginate(10); // Cache the paginated results
        });

        return response()->json($items);
    }



//    getItemById func with redis cashing:
    public function getItemById($itemId)
    {
        $cacheKey = "item_{$itemId}";

        // Retrieve cached data or query and cache
        $item = Cache::remember($cacheKey, now()->addHours(1), function () use ($itemId) {
            $item = Item::with(['section', 'tags', 'categories'])->find($itemId);
            if (!$item) {
                return null; // Null will not be cached
            }

            return [
                'id' => $item->id,
                'title' => $item->title,
                'cover_image' => $item->cover_image,
                'author_or_guest' => $item->author_or_guest,
                'narrator' => $item->narrator,
                'release_year' => $item->release_year,
                'short_summary' => $item->short_summary,
                'detailed_summary' => $item->detailed_summary,
                'section' => $item->section ? $item->section->name : null,
                'tags' => $item->tags->pluck('name')->toArray(),
                'categories' => $item->categories->pluck('name')->toArray(),
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Cache::forget('user_profile_*');


        return response()->json($item, 200);
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'string|nullable',
            'author_or_guest' => 'string|nullable',
            'release_year' => 'nullable',
            'narrator' => 'string|nullable',
            'short_summary' => 'required|string|max:200',
            'detailed_summary' => 'required|string',
            'section_id' => 'required',
        ]);

        $item = Item::create($validatedData);

        if ($request->has('tags')) {
            $item->tags()->attach($request->input('tags'));
        }

        if ($request->has('categories')) {
            $item->categories()->attach($request->input('categories'));
        }

        //  clear redis cash
        Cache::forget('items_*'); // Invalidate all items cache

        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    /**
     * Display the specified item.
     */
    public function show($id)
    {
        $item = Item::with(['tags', 'categories'])->findOrFail($id);

        return response()->json($item);
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'string|nullable',
            'author_or_guest' => 'string|nullable',
            'release_year' => 'nullable',
            'narrator' => 'string|nullable',
            'short_summary' => 'required|string|max:200',
            'detailed_summary' => 'required|string',
            'section_id' => 'required',
        ]);

        $item->update($validatedData);

        if ($request->has('tags')) {
            $item->tags()->sync($request->input('tags'));
        }

        if ($request->has('categories')) {
            $item->categories()->sync($request->input('categories'));
        }

        Cache::forget("item_{$id}"); // Clear cache for this item
        Cache::forget('items_*');   // Optionally clear list cache
        Cache::forget('most_viewed_items'); // Clear most viewed cache
        Cache::forget('user_profile_*'); // Clear most viewed cache



        return response()->json(['message' => 'Item updated successfully', 'item' => $item]);
    }





    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        Cache::forget("item_{$id}"); // Clear cache for this item
        Cache::forget('items_*');   // Optionally clear list cache
        Cache::forget('user_profile_'); // Clear most viewed cache


        return response()->json(['message' => 'Item deleted successfully']);
    }

    /**
     * Increment view count for a specified item.
     */
    public function incrementViewCount($itemId)
    {
        $mostViewed = MostViewed::firstOrCreate(['item_id' => $itemId]);
        $mostViewed->increment('view_count');

        Cache::forget('most_viewed_items'); // Clear most viewed cache
        return response()->json(['message' => 'View count incremented successfully']);
    }

    /**
     * Get a if authenticated user is saved the current item .
     */

    public function getItemStates($itemId)
    {
        $user = auth()->user(); // Ensure the user is authenticated
        $cacheKey = "user_{$user->id}_item_{$itemId}_states";

        // Attempt to retrieve states from the cache
        $itemStates = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($user, $itemId) {
            $liked = $user->likes()->where('item_id', $itemId)->exists();
            $saved = $user->saves()->where('item_id', $itemId)->exists();

            return [
                'liked' => $liked,
                'saved' => $saved,
            ];
        });

        return response()->json($itemStates);
    }


//    GetMostViewed Func with Cashing:
    public function getMostViewed()
    {
        $cacheKey = 'most_viewed_items';

        // Retrieve cached data or query and cache
        $mostViewedItems = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return MostViewed::with(['item.section', 'item.tags', 'item.categories'])
                ->orderBy('view_count', 'desc')
                ->take(10)
                ->get()
                ->map(function ($mostViewedItem) {
                    return [
                        'id' => $mostViewedItem->item->id,
                        'title' => $mostViewedItem->item->title,
                        'cover_image' => $mostViewedItem->item->cover_image,
                        'author_or_guest' => $mostViewedItem->item->author_or_guest,
                        'narrator' => $mostViewedItem->item->narrator,
                        'release_year' => $mostViewedItem->item->release_year,
                        'short_summary' => $mostViewedItem->item->short_summary,
                        'detailed_summary' => $mostViewedItem->item->detailed_summary,
                        'section' => $mostViewedItem->item->section ? $mostViewedItem->item->section->name : null,
                        'tags' => $mostViewedItem->item->tags->pluck('name')->toArray(),
                        'categories' => $mostViewedItem->item->categories->pluck('name')->toArray(),
                    ];
                });
        });

        return response()->json($mostViewedItems);
    }




    /**
     * Remove an item from the most viewed list.
     */
    public function removeFromMostViewed($itemId)
    {
        MostViewed::where('item_id', $itemId)->delete();

        // todo: besure forget the cash when edit here
        return response()->json(['message' => 'Item removed from most viewed list']);
    }

    /**
     * Attach a tag to an item.
     */
    public function attachTag(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $item->tags()->attach($request->tag_id);

        return response()->json(['message' => 'Tag attached successfully']);
    }

    /**
     * Detach a tag from an item.
     */
    public function detachTag(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $item->tags()->detach($request->tag_id);

        return response()->json(['message' => 'Tag detached successfully']);
    }

    /**
     * Attach a category to an item.
     */
    public function attachCategory(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $item->categories()->attach($request->category_id);

        return response()->json(['message' => 'Category attached successfully']);
    }

    /**
     * Detach a category from an item.
     */
    public function detachCategory(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $item->categories()->detach($request->category_id);

        return response()->json(['message' => 'Category detached successfully']);
    }
}
