<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Gestion des Anniversaires</h1>

        <!-- Alertes anniversaires -->
        @if($birthdaysToday->count() > 0)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                <p class="font-bold">🎉 Anniversaires aujourd'hui :</p>
                @foreach($birthdaysToday as $contact)
                    <p>{{ $contact->full_name }} ({{ $contact->age }} ans)</p>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Barre d'outils -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex gap-4 items-center">
                <!-- Recherche -->
                <input wire:model.live="search" type="text" placeholder="Rechercher un contact..."
                    class="border rounded-lg px-3 py-2 w-64">

                <!-- Filtre -->
                <select wire:model.live="filterBy" class="border rounded-lg px-3 py-2">
                    <option value="all">Tous les contacts</option>
                    <option value="today">Anniversaires aujourd'hui</option>
                    <option value="this_month">Ce mois-ci</option>
                    <option value="next_30_days">30 prochains jours</option>
                </select>
            </div>

            <a href="{{ route('contacts.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un contact
            </a>
        </div>
    </div>

    <!-- Messages flash -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tableau des contacts -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('first_name')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Nom
                        @if($sortBy === 'first_name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact
                    </th>
                    <th wire:click="sortBy('birth_date')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        Anniversaire
                        @if($sortBy === 'birth_date')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Âge
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Prochain anniversaire
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contacts as $contact)
                    <tr class="{{ $contact->is_birthday_today ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">
                                {{ $contact->full_name }}
                                @if($contact->is_birthday_today)
                                    <span class="ml-2">🎂</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($contact->email)
                                <div>{{ $contact->email }}</div>
                            @endif
                            @if($contact->phone)
                                <div>{{ $contact->phone }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $contact->birth_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $contact->age }} ans
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($contact->days_until_birthday === 0)
                                <span class="text-yellow-600 font-semibold">Aujourd'hui !</span>
                            @elseif($contact->days_until_birthday === 1)
                                <span class="text-orange-600">Demain</span>
                            @else
                                Dans {{ $contact->days_until_birthday }} jours
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('contacts.edit', $contact) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                            <button wire:click="deleteContact({{ $contact->id }})"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')"
                                class="text-red-600 hover:text-red-900">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucun contact trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
</div>