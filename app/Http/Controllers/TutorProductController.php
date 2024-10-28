<?php

namespace App\Http\Controllers;

use App\Imports\TutorProductImport;
use App\Models\TutorProduct;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class TutorProductController extends Controller
{
    // Import CSV file via API route
    public function importCsv(Request $request)
    {
        // Validate the uploaded file to ensure it is a CSV
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            // Use Laravel Excel to import CSV data
            Excel::import(new TutorProductImport, $request->file('file'));

            return response()->json(['message' => 'CSV imported successfully'], Response::HTTP_CREATED);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = $e->failures();

            return response()->json([
                'message' => 'Validation failed for some rows',
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $e) {
            // Catch any other exceptions
            return response()->json([
                'message' => 'An error occurred while importing CSV',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // List imported TutorProducts with pagination
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $tutorProducts = TutorProduct::paginate($perPage);

        return response()->json($tutorProducts);
    }
}
