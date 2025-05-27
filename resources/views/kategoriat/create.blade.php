<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($kategoria) ? 'Muokkaa kategorian tietoja' : 'Lisää kategoria' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-white">
        <form action="{{ isset($kategoria) ? route('kategoriat.update', $kategoria) : route('kategoriat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($kategoria)
                @method('PUT')
            @endisset

            <div class="flex flex-col gap-5">
                <label for="nimi">Nimi:</label>
                <input class="text-gray-900" type="text" name="nimi" value="{{ $kategoria -> nimi ?? '' }}" placeholder="Nimi" required>
                <label for="kuva">Kuva:</label>
                <input class="text-gray-900" type="file" name="kuva">

                <button type="submit" class="bg-blue-500">Tallenna</button>
            </div>
        </form>
    </div>
</x-app-layout>