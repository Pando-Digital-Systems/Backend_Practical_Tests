<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'contact', 'website'];

    public function tutorProducts()
    {
        return $this->hasMany(TutorProduct::class);
    }
}
