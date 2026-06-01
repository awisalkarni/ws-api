<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Solat API — Admin</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="text-white font-bold text-lg">Waktu Solat Admin</div>
                        <div class="ml-10 flex items-baseline gap-4">
                            <a href="{{ route('admin.dashboard') }}" wire:navigate
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.zones') }}" wire:navigate
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.zones*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Zones
                            </a>
                            <a href="{{ route('admin.prayer-times') }}" wire:navigate
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.prayer-times*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Prayer Times
                            </a>
                            <a href="{{ route('admin.sync-logs') }}" wire:navigate
                               class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.sync-logs*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Sync Logs
                            </a>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
