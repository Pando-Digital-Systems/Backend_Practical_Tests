<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
class TeamController extends Controller
{
    public function index()
    {
        return Team::with('tutorProducts')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'website' => 'required|url',
        ]);

        $team = Team::create($validatedData);
        return response()->json($team, 201);
    }

    public function show($id)
    {
        return Team::with('tutorProducts')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'website' => 'required|url',
        ]);

        $team->update($validatedData);
        return response()->json($team, 200);
    }

    public function destroy($id)
    {
        Team::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}