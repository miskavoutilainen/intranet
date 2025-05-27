<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'nimi', 'hinta', 'kuva', 'kategoria_id'
    ];

    // Tällä funktiolla voi tarkistaa, mihin kategoriaan tuote kuuluu
    public function kategoria() {
        return $this->belongsTo(Kategoria::class);
    }

}
