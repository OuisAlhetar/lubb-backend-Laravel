<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all(), 200);
    }

    public function store(Request $request)
    {
        $tag = Tag::create($request->all());
        return response()->json($tag, 201);
    }

    public function show($id)
    {
        return response()->json(Tag::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());

        // for clear cache
        Cache::forget('most_viewed_items');
        return response()->json($tag, 200);
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        // for clear cache
        Cache::forget('most_viewed_items');
        return response()->json(['message' => 'Tag deleted successfully'], 200);
    }
}