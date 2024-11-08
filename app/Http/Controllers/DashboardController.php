<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PassenAanvraag;
use App\Models\Huisdier;

class DashboardController extends Controller
{
    public function index()
    {
        // Haal alle huisdieren op die aan de ingelogde gebruiker zijn gekoppeld
        $huisdieren = Huisdier::where('user_id', auth()->id())
            ->with(['aanmeldingen.oppasser.user']) // Zorg ervoor dat je de juiste relaties ophaalt
            ->get();
    
        // Controleer of de gebruiker een oppasser is
        $user = Auth::user();
        $oppasserId = $user->oppasser ? $user->oppasser->id : null;
    
        // Haal aanmeldingen op als de gebruiker een oppasser is
        $aanmeldingen = $oppasserId ? PassenAanvraag::where('oppasser_id', $oppasserId)
            ->with('huisdier') // Zorg ervoor dat je de relatie naar huisdieren ophaalt
            ->get() : collect(); // Geef een lege collectie terug als de gebruiker geen oppasser is
    
        // Geef de huisdieren en aanmeldingen door aan de dashboard view
        return view('dashboard', compact('huisdieren', 'aanmeldingen'));
    }
}
