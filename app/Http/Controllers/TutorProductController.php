namespace App\Http\Controllers;

use App\Models\TutorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TutorProductController extends Controller
{
    // Import CSV Data
    public function importCsv(Request $request)
    {
        // Validate if the uploaded file is a CSV
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $fileHandle = fopen($file, 'r');

        fgetcsv($fileHandle);

        $data = [];
        while (($row = fgetcsv($fileHandle)) !== false) {
            // Data validation
            $validator = Validator::make([
                'title' => $row[0],
                'description' => $row[1],
            ], [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 400);
            }

            $data[] = [
                'title' => $row[0],
                'description' => $row[1],
            ];
        }

        fclose($fileHandle);

        // Insert data into the database
        TutorProduct::insert($data);

        return response()->json(['message' => 'CSV imported successfully'], 201);
    }

    // List imported TutorProducts with pagination
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $tutorProducts = TutorProduct::paginate($perPage);

        return response()->json($tutorProducts);
    }
}
