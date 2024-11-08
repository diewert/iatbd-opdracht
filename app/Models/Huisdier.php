<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Huisdier extends Model
{
    use HasFactory;
    
    protected $table = 'huisdieren';

    protected $fillable = ['naam', 'soort', 'uurtarief', 'begin_datum', 'eind_datum', 'achtergrond_informatie', 'foto', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function aanmeldingen()
    {
        return $this->hasMany(PassenAanvraag::class, 'huisdier_id');
    }
}
