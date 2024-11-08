<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oppasser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'profielfoto',
        'huisfoto',
        'beschrijving'
    ];

    protected $casts = [
        'reviews' => 'array',
    ];
    

    // Relatie met de gebruiker
    public function user()
    {
        return $this->belongsTo(User::class);
        
    }
}
