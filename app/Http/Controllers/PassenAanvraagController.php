<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PassenAanvraag;
use App\Models\Huisdier;
use Illuminate\Support\Facades\Auth;

class PassenAanvraagController extends Controller
{
    public function store(Request $request, $huisdierId)
    {
        $huisdier = Huisdier::findOrFail($huisdierId);
        
        // Controleer of de oppasser zich al heeft aangemeld
        $existingAanvraag = PassenAanvraag::where('oppasser_id', Auth::id())
            ->where('huisdier_id', $huisdierId)
            ->first();

        if ($existingAanvraag) {
            return redirect()->back()->with('message', 'Je hebt je al aangemeld voor dit huisdier.');
        }
        
        PassenAanvraag::create([
            'oppasser_id' => Auth::user()->oppasser->id, // Oppasser moet ingelogd zijn
            'huisdier_id' => $huisdier->id,
            'eigenaar_id' => $huisdier->user_id, // Verander naar user_id om de eigenaar te verkrijgen
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Aanmelding ingediend!');
    }

    // Eigenaar accepteert of weigert de aanvraag
    public function update(Request $request, $aanvraagId)
    {
        $aanvraag = PassenAanvraag::findOrFail($aanvraagId);

        // Controleer of de ingelogde gebruiker de eigenaar van het huisdier is
        $huisdier = Huisdier::findOrFail($aanvraag->huisdier_id);
        if (Auth::id() !== $huisdier->user_id) {
            return redirect()->back()->with('error', 'Je hebt geen toestemming om deze aanvraag te beheren.');
        }

        if ($request->action == 'accept') {
            $aanvraag->update(['status' => 'accepted']);
        } else if ($request->action == 'reject') {
            $aanvraag->update(['status' => 'rejected']);
        }

        return redirect()->back()->with('success', 'Aanvraag bijgewerkt.');
    }
}
