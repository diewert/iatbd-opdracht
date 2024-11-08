<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oppasser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OppasserController extends Controller
{   
    public function index()
    {
        $oppassers = Oppasser::with('user')->get(); 
        return view('oppassers', compact('oppassers'));
    }

    public function storeReview(Request $request, $oppasserId)
    {
        $request->validate([
         'review' => 'required|string|max:255',
        ]);

        $oppasser = Oppasser::findOrFail($oppasserId);
        $reviews = $oppasser->reviews ?? [];

        // Voeg de nieuwe review toe aan de array
        $reviews[] = [
            'user_id' => Auth::id(),
            'review' => $request->input('review'),
            'created_at' => now(),
        ];

        // Update de reviews kolom in de database
        $oppasser->reviews = $reviews;
        $oppasser->save();

        return redirect()->back()->with('success', 'Review toegevoegd!');
}



    // Specifieke oppasser tonen
    public function show($id)
    {
        {
            // Haal de oppasser op uit de database via het ID
            $oppasser = Oppasser::findOrFail($id);

            $reviewsWithNames = collect($oppasser->reviews)->map(function ($review) {
                $user = User::find($review['user_id']);
                return [
                    'user_name' => $user ? $user->name : 'Verwijderde gebruiker',
                    'review' => $review['review'],
                    'created_at' => $review['created_at'],
                ];
            });
            // Stuur de oppasser data door naar de view
            return view('oppassers.show', compact('oppasser', 'reviewsWithNames'));
        }
    }

    public function create()
    {
        return view('createOpasser');
    }

    public function store(Request $request)
{
    // Validatie
    $validated = $request->validate([
        'profielfoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'huisfoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'beschrijving' => 'nullable|string',
    ]);

    // Check of de gebruiker al een oppasser is
    $existingOppasser = Oppasser::where('user_id', Auth::id())->first();

    // Verwerken van de upload van profielfoto
    if ($request->hasFile('profielfoto')) {
        $profielfoto = $request->file('profielfoto')->store('oppassers/profielfotos', 'public');
        $validated['profielfoto'] = $profielfoto;
    }

    // Verwerken van de upload van huisfoto
    if ($request->hasFile('huisfoto')) {
        $huisfoto = $request->file('huisfoto')->store('oppassers/huisfotos', 'public');
        $validated['huisfoto'] = $huisfoto;
    }

    if ($existingOppasser) {
        // Update het bestaande oppasser-profiel
        $existingOppasser->update($validated);
        return redirect()->route('oppassers.index')->with('success', 'Je oppasser-profiel is bijgewerkt!');
    } else {
        // Als de gebruiker geen oppasser is, maak een nieuw profiel aan
        Oppasser::create([
            'user_id' => Auth::id(),
            'profielfoto' => $validated['profielfoto'] ?? null,
            'huisfoto' => $validated['huisfoto'] ?? null,
            'beschrijving' => $validated['beschrijving'] ?? '',
        ]);

        return redirect()->route('oppassers.index')->with('success', 'Je hebt je aangemeld als oppasser!');
    }
}
}
