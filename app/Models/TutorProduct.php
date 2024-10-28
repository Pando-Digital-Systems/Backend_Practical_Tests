<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProduct extends Model
{
    use HasFactory;

    protected $table = 'TutorProduct'; // table name

    protected $fillable = [
        'title',
        'description',
    ];

}
