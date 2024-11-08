<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassenAanvraag extends Model
{
    use HasFactory;

    protected $table = 'passen_aanvragen';
    
    protected $fillable = ['oppasser_id', 'huisdier_id', 'eigenaar_id', 'status'];

    // Relaties
    public function oppasser()
    {
        return $this->belongsTo(Oppasser::class);
    }

    public function huisdier()
    {
        return $this->belongsTo(Huisdier::class);
    }

    public function eigenaar()
    {
        return $this->belongsTo(User::class, 'eigenaar_id');
    }
}
