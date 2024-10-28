<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorProduct;

class TutorProductController extends Controller
{
    public function index()
    {
        return TutorProduct::with('team')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $tutorProduct = TutorProduct::create($validatedData);
        return response()->json($tutorProduct, 201);
    }

    public function show($id)
    {
        return TutorProduct::with('team')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $tutorProduct = TutorProduct::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $tutorProduct->update($validatedData);
        return response()->json($tutorProduct, 200);
    }

    public function destroy($id)
    {
        TutorProduct::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
