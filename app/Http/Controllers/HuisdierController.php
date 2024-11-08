<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Huisdier;
use Illuminate\Support\Facades\Auth;

class HuisdierController extends Controller
{
    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        return view('create');
    }
 
    public function index()
    {
        // Haal alle huisdieren op die aan de ingelogde gebruiker zijn gekoppeld
        $huisdieren = Huisdier::where('user_id', auth()->id())->get();

        // Geef de huisdieren door aan de dashboard view
        return view('huisdieren', compact('huisdieren'));
    }

    public function aanvragen(Request $request)
    {
        // Haal alle huisdieren op
        $query = Huisdier::query();

        // Filter op soort
        if ($request->has('soort') && $request->soort != '') {
        $query->where('soort', $request->soort);
        }

        // Filter op prijs
        if ($request->has('min_uurtarief') && $request->min_uurtarief != '') {
        $query->where('uurtarief', '>=', $request->min_uurtarief);
        }

        if ($request->has('max_uurtarief') && $request->max_uurtarief != '') {
        $query->where('uurtarief', '<=', $request->max_uurtarief);
        }

        // Voer de query uit en haal de resultaten op
        $huisdieren = $query->get(); 

        // Geef de huisdieren door aan de aanvragen view
        return view('aanvragen', compact('huisdieren'));
    }


    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request)
{
    // Validatie
    $validated = $request->validate([
        'naam' => 'required|string|max:255',
        'soort' => 'required|string|in:hond,kat,schildpad,konijn',
        'uurtarief' => 'required|numeric|min:0',
        'begin_datum' => 'required|date',
        'eind_datum' => 'required|date|after_or_equal:begin_datum',
        'achtergrond_informatie' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Verwerken van het uploaden van de afbeelding
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        // Geef het bestand een unieke naam en sla het op in de map 'public/huisdieren'
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('huisdieren', $filename, 'public'); // Opslaan in de 'public' folder

        // Voeg het pad van de foto toe aan de validated data
        $validated['foto'] = $path; // Gebruik $validated in plaats van $validatedData
    }

    // Huisdier aanmaken en opslaan in de database
    $huisdier = new Huisdier($validated); // Hier gebruiken we $validated
    $huisdier->user_id = auth()->id(); // Koppel aan de ingelogde gebruiker
    $huisdier->save();

    // Doorverwijzen naar dashboard of succesmelding
    return redirect()->route('huisdieren.index')->with('success', 'Huisdier succesvol aangemaakt!');
}

}
