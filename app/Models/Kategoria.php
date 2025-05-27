<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nimi', 'kuva'
    ];

    // Haetaan kategoriaan kuuluvat tuotteet
    public function tuotteet() {
        return $this -> hasMany(Tuote::class);
    }
}
