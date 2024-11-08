<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PassenAanvraag;

class AdminController extends Controller
{
    // Toon een lijst van gebruikers
    public function index()
    {
        $requests = PassenAanvraag::with('huisdier', 'oppasser')->get();
        $users = User::all(); // Haal alle gebruikers op
        return view('admin.index', compact('users', 'requests'));
    }

    // Blokkeer een gebruiker
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->back()->with('success', 'Gebruiker is geblokkeerd.');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false; // Gebruiker deblokkeren
        $user->save();

        return redirect()->back()->with('success', 'De gebruiker is gedeblokkeerd.');
    }

    // Verwijder een aanvraag
    public function deleteRequest($id)
    {
        $request = PassenAanvraag::findOrFail($id);
        $request->delete();

        return redirect()->back()->with('success', 'Aanvraag is verwijderd.');
    }
}
