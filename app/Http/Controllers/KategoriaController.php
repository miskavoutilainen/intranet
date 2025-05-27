<?php

namespace App\Http\Controllers;

use App\Models\Kategoria;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class KategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriat = Kategoria::all();
        return view('kategoriat.index', compact('kategoriat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriat = Kategoria::all();
        return view('kategoriat.create', compact('kategoriat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nimi' => 'required',
            'kuva' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Talletetaan validated muuttujaan kaikki pyynnön arvot
        $validated = $request -> all();

        // Ladataan kuva palvelimelle
        if ($request -> hasFile('kuva')) {
            $path = $request -> file('kuva') -> store('kuvat', 'public');
            // Muutetaan validated muuttujan kuvan tietoja (asetetaan oikea polku)
            $validated['kuva'] = $path;
        }

        // Luodaan tuote validated muuttujan tiedoilla
        Kategoria::create($validated);

        return redirect() -> route('kategoriat.index') -> with('success', 'Kategoria lisätty!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategoria $kategoria)
    {
        return view('kategoriat.edit', compact('kategoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategoria $kategoria)
    {
        $request -> validate([
            'nimi' => 'required',
            'kuva' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $validated = $request -> all();

        // Ladataan uusi kuva palvelimelle
        if ($request -> hasFile('kuva')) {
            // Poistetaan vanha kuva jos sellainen on
            if ($kategoria -> kuva) {
                Storage::disk('public') -> delete($kategoria -> kuva);
            }

            $path = $request -> file('kuva') -> store('kuvat', 'public');
            $validated['kuva'] = $path;
        }

        $kategoria -> update($validated);

        return redirect() -> route('kategoriat.index') -> with('success', 'Kategoria päivitetty');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategoria $kategoria)
    {
        // Poistetaan kuva
        if ($kategoria -> kuva) {        
            Storage::disk('public') -> delete($kategoria -> kuva);
        }

        $kategoria -> delete();
        return redirect() -> route('kategoriat.index') -> with('success', 'Kategoria poistettu');
    }
}
