<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($tuote) ? 'Muokkaa tuotteen tietoja' : 'Lisää tuote' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-white">
        <form action="{{ isset($tuote) ? route('tuotteet.update', $tuote) : route('tuotteet.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($tuote)
                @method('PUT')
            @endisset

            <div class="flex flex-col gap-5">
                <label for="nimi">Nimi:</label>
                <input class="text-gray-900" type="text" name="nimi" value="{{ $tuote -> nimi ?? '' }}" placeholder="Nimi" required>
                <label for="nimi">Hinta:</label>
                <input class="text-gray-900" type="text" name="hinta" value="{{ $tuote -> hinta ?? '' }}" placeholder="Hinta" required>
                <label for="kuva">Kuva:</label>
                <input class="text-gray-900" type="file" name="kuva">
    
                <button type="submit" class="bg-blue-500">Tallenna</button>
            </div>
        </form>
    </div>
</x-app-layout>