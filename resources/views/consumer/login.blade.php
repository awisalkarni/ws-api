<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Solat API — Sign In</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-2xl font-bold text-gray-900">Sign In</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Enter your email and API key to access your dashboard.</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white px-6 py-8 shadow-sm rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm font-medium text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('consumer.login') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="api_key" class="block text-sm font-medium text-gray-900">API Key</label>
                        <input type="text" name="api_key" id="api_key" required
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300">
                        <label for="remember" class="text-sm text-gray-600">Remember me</label>
                    </div>

                    <button type="submit" class="w-full rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                        Sign In
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-500">
                    Don't have a key?
                    <a href="{{ route('consumer.register') }}" class="font-medium text-gray-900 hover:underline">Register</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
