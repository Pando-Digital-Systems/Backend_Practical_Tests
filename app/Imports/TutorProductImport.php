<?php

namespace App\Imports;

use App\Models\TutorProduct;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class TutorProductImport implements ToModel, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        // Return a new TutorProduct instance with mapped CSV fields
        return new TutorProduct([
            'title' => $row[0],
            'description' => $row[1],
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string|max:255', // Title validation
            '1' => 'nullable|string',         // Description validation
        ];
    }
}
