<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Gestion des Anniversaires') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-gray-800">🎂 Anniversaires</h1>
                    <div class="flex space-x-4 ml-8">
                        <a href="{{ route('contacts.index') }}"
                            class="text-blue-600 hover:text-blue-800 {{ request()->routeIs('contacts.index') ? 'font-semibold' : '' }}">
                            Contacts
                        </a>
                        <a href="{{ route('contacts.create') }}"
                            class="text-blue-600 hover:text-blue-800 {{ request()->routeIs('contacts.create') ? 'font-semibold' : '' }}">
                            Nouveau contact
                        </a>
                        <a href="{{ route('settings') }}"
                            class="text-blue-600 hover:text-blue-800 {{ request()->routeIs('settings') ? 'font-semibold' : '' }}">
                            Paramètres
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>