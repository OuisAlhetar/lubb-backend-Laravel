<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        return response()->json(Section::all(), 200);
    }

    public function store(Request $request)
    {
        $section = Section::create($request->all());
        return response()->json($section, 201);
    }

    public function show($id)
    {
        return response()->json(data: Section::findOrFail($id), status: 200);
    }

    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->all());
        return response()->json($section, 200);
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return response()->json(['message' => 'Section deleted successfully'], 200);
    }
}