<?php

namespace App\Http\Controllers;

use App\Models\Tuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tuotteet = Tuote::all();
        return view('tuotteet.index', compact('tuotteet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tuotteet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nimi' => 'required',
            'hinta' => 'required|numeric',
            'kuva' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Talletetaan validated muuttujaan kaikki pyynnön arvot
        $validated = $request->all();

        // Ladataan kuva palvelimelle
        if ($request -> hasFile('kuva')) {
            $path = $request -> file('kuva') -> store('kuvat', 'public');
            // Muutetaan validated muuttujan kuvan tietoja (asetetaan oikea polku)
            $validated['kuva'] = $path;
        }

        // Luodaan tuote validated muuttujan tiedoilla
        Tuote::create($validated);


        return redirect() -> route('tuotteet.index') -> with('success', 'Tuote lisätty!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tuote $tuote)
    {
        return view('tuotteet.edit', compact('tuote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tuote $tuote)
    {
        $request -> validate([
            'nimi' => 'required',
            'hinta' => 'required|numeric',
            'kuva' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $validated = $request -> all();

        // Ladataan uusi kuva palvelimelle
        if ($request -> hasFile('kuva')) {
            // Poistetaan vanha kuva jos sellainen on
            if ($tuote -> kuva) {
                Storage::disk('public') -> delete($tuote -> kuva);
            }

            $path = $request -> file('kuva') -> store('kuvat', 'public');
            $validated['kuva'] = $path;
        }

        $tuote -> update($validated);

        return redirect() -> route('tuotteet.index') -> with('success', 'Tuote päivitetty');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tuote $tuote)
    {
        // Poistetaan kuva
        if ($tuote -> kuva) {        
            Storage::disk('public') -> delete($tuote -> kuva);
        }

        $tuote -> delete();
        return redirect() -> route('tuotteet.index') -> with('success', 'Tuote poistettu');
    }
}
