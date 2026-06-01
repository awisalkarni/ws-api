<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Solat API — Consumer</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div>
                        <a href="{{ route('consumer.dashboard') }}" class="text-white font-bold text-lg" wire:navigate>Waktu Solat API</a>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <span class="text-sm text-gray-300">{{ Auth::user()->name }}</span>
                            <a href="{{ route('docs') }}" class="text-sm text-gray-300 hover:text-white">Docs</a>
                            <form action="{{ route('consumer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-gray-300 hover:text-white">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('consumer.login') }}" class="text-sm text-gray-300 hover:text-white">Sign In</a>
                        @endauth
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

                @if (session('api_key'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-6">
                        <h3 class="text-lg font-semibold text-green-900">Your API Key</h3>
                        <p class="mt-1 text-sm text-green-700">Save this key. You won't be able to see it again.</p>
                        <div class="mt-3 flex items-center gap-2">
                            <code class="flex-1 rounded bg-green-100 px-3 py-2 text-sm font-mono text-green-900 break-all">{{ session('api_key') }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ session('api_key') }}')" class="rounded-md bg-green-700 px-3 py-2 text-sm font-medium text-white hover:bg-green-600 shrink-0">Copy</button>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
