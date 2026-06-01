<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Solat API — Get Your API Key</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-2xl font-bold text-gray-900">Get Your API Key</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Register to access the Waktu Solat API.</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white px-6 py-8 shadow-sm rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm font-medium text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('consumer.register') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                        Generate API Key
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-500">
                    Already have a key?
                    <a href="{{ route('consumer.login') }}" class="font-medium text-gray-900 hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
