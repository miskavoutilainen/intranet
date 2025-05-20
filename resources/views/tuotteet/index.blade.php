<style>
    .hallintanapit {
        display: flex;
        gap: 10px;
        justify-content: left;
        flex-wrap: wrap;
    }

    .hallintanappi {
        padding: 10px;
        background-color: #dddddd;
        height: 40px;
        border-radius: 5px;
        color: black;
    }

    .hallintanappi:hover {
        background-color: rgb(190, 190, 190);
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tuotteet') }}
            </h2>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                <!-- Näytetään lisää tuote nappi, jos kirjautunut käyttäjä isAdmin -->
                @if(auth() -> user() -> isAdmin())
                    <x-nav-link :href="route('tuotteet.create')" :active="request()->routeIs('tuotteet.create')">
                        {{ __('Lisää tuote') }}
                    </x-nav-link>
                @endif

            </div>

        </div>
    </x-slot>

    @if (session('success'))
        <div class="py-3 sm:px-6 lg:px-8" style="background-color: #ccffcc; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-l text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nimi</th>
                            <th scope="col" class="px-6 py-3">Hinta</th>
                            <th scope="col" class="px-6 py-3">Kuva</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tuotteet as $tuote)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $tuote->id }}</td>
                                <td class="px-6 py-4">{{ $tuote->nimi }}</td>
                                <td class="px-6 py-4">{{ $tuote->hinta }} €</td>
                                <td class="px-6 py-4">
                                    @if($tuote->kuva)
                                        <a href="{{ asset('storage/' . $tuote->kuva) }}">
                                            <img src="{{ asset('storage/' . $tuote->kuva) }}" width="80">
                                        </a>
                                    @else
                                        Ei kuvaa
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="hallintanapit">
                                        
                                        <!-- Näytetään muokkaa ja poista napit jos kirjautunut käyttäjä isAdmin -->
                                        @if(auth() -> user() -> isAdmin())
                                            <a class="hallintanappi" style="background-color: bisque;"
                                                href="{{ route('tuotteet.edit', $tuote) }}">Muokkaa</a>
                                            <form action="{{ route('tuotteet.destroy', $tuote) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button class="hallintanappi" style="background-color: lightcoral;"
                                                    onclick="return confirm('Poistetaanko?')">Poista</button>
                                            </form>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>

                            <!-- Jos tuotteita ei ole -->
                        @empty
                            <tr>
                                <td colspan="5">Ei tuotteita</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>