<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Solat API — Docs</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="text-white font-bold text-lg">Waktu Solat API Docs</div>
                    <a href="{{ url('/') }}" class="text-sm text-gray-300 hover:text-white">Back to Site</a>
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Waktu Solat API Documentation</h1>
            <p class="mt-2 text-gray-600">Malaysian prayer times API sourced from JAKIM's official e-Solat portal.</p>

            <div class="mt-8 rounded-lg bg-amber-50 border border-amber-200 p-4">
                <p class="text-sm font-medium text-amber-800">All API endpoints require an API key. Register first to get your key.</p>
            </div>

            <!-- Authentication -->
            <h2 class="mt-10 text-xl font-semibold text-gray-900">Authentication</h2>
            <p class="mt-2 text-sm text-gray-600">Include your API key in every request using one of these methods:</p>
            <ul class="mt-2 list-disc list-inside text-sm text-gray-600 space-y-1">
                <li>Authorization header: <code class="bg-gray-200 px-1 rounded">Authorization: Bearer YOUR_API_KEY</code></li>
                <li>Query parameter: <code class="bg-gray-200 px-1 rounded">?api_key=YOUR_API_KEY</code></li>
            </ul>

            <!-- Register -->
            <h3 class="mt-6 text-lg font-semibold text-gray-800">Register</h3>
            <p class="text-sm text-gray-600">Create an account to receive your API key.</p>
            <div class="mt-2 p-4 rounded-lg bg-white border border-gray-200">
                <p class="text-sm text-gray-600 mb-2">Visit the registration page to sign up and get your API key instantly:</p>
                <a href="{{ url('/register') }}" class="inline-block rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Register for API Key</a>
            </div>

            <!-- List Zones -->
            <h3 class="mt-8 text-lg font-semibold text-gray-800">List All Zones</h3>
            <p class="text-sm text-gray-600">Returns all supported prayer time zones in Malaysia.</p>
            <div class="mt-2 overflow-hidden rounded-lg bg-gray-800 text-white">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">GET</span>
                    <span class="text-sm font-mono">/api/v1/zones</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 mb-2">Response:</p>
                    <pre class="text-sm overflow-x-auto"><code>{
  "data": [
    {
      "id": 1,
      "code": "SGR01",
      "state": "Selangor",
      "description": "Gombak, Petaling, Sepang..."
    }
  ]
}</code></pre>
                </div>
            </div>

            <!-- Zone Prayer Times -->
            <h3 class="mt-8 text-lg font-semibold text-gray-800">Get Prayer Times by Zone</h3>
            <p class="text-sm text-gray-600">Returns prayer times for a specific zone. Defaults to today.</p>
            <div class="mt-2 overflow-hidden rounded-lg bg-gray-800 text-white">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">GET</span>
                    <span class="text-sm font-mono">/api/v1/zones/{zone_code}</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 mb-2">Query Parameters:</p>
                    <table class="w-full text-xs text-gray-300 mb-4">
                        <tr><td class="py-1 pr-4 font-mono">date</td><td class="py-1">Specific date (YYYY-MM-DD)</td></tr>
                        <tr><td class="py-1 pr-4 font-mono">month</td><td class="py-1">Month number (requires year)</td></tr>
                        <tr><td class="py-1 pr-4 font-mono">year</td><td class="py-1">Year number</td></tr>
                    </table>
                    <p class="text-xs text-gray-400 mb-2">Example:</p>
                    <pre class="text-sm overflow-x-auto"><code>GET /api/v1/zones/SGR01?date=2026-06-15
GET /api/v1/zones/SGR01?month=6&year=2026
GET /api/v1/zones/SGR01&api_key=ws_xxx</code></pre>
                </div>
            </div>

            <!-- Today's Prayer Times -->
            <h3 class="mt-8 text-lg font-semibold text-gray-800">Today's Prayer Times</h3>
            <p class="text-sm text-gray-600">Get today's prayer time for a specific zone.</p>
            <div class="mt-2 overflow-hidden rounded-lg bg-gray-800 text-white">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">GET</span>
                    <span class="text-sm font-mono">/api/v1/prayer-times/today?zone=SGR01</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 mb-2">Response:</p>
                    <pre class="text-sm overflow-x-auto"><code>{
  "data": {
    "zone": { "code": "SGR01", "state": "Selangor", "description": "..." },
    "date": "2026-06-01",
    "prayers": {
      "imsak": "05:40",
      "subuh": "05:50",
      "syuruk": "07:12",
      "zohor": "13:15",
      "asar": "16:35",
      "maghrib": "19:21",
      "isyak": "20:32",
      "dhuha": "07:39"
    }
  }
}</code></pre>
                </div>
            </div>

            <!-- Specific Date -->
            <h3 class="mt-8 text-lg font-semibold text-gray-800">Prayer Times by Date</h3>
            <p class="text-sm text-gray-600">Get prayer times for a specific date and zone.</p>
            <div class="mt-2 overflow-hidden rounded-lg bg-gray-800 text-white">
                <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">GET</span>
                    <span class="text-sm font-mono">/api/v1/prayer-times/date/{date}?zone=SGR01</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-400 mb-2">Example:</p>
                    <pre class="text-sm overflow-x-auto"><code>GET /api/v1/prayer-times/date/2026-06-01?zone=SGR01</code></pre>
                </div>
            </div>

            <!-- Prayer Times Reference -->
            <h2 class="mt-10 text-xl font-semibold text-gray-900">Prayer Times</h2>
            <table class="mt-4 w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-500">Prayer</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500">Description</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-4 py-2 font-medium">Imsak</td><td class="px-4 py-2 text-gray-600">Time to stop eating before dawn (Sahur ends)</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Subuh</td><td class="px-4 py-2 text-gray-600">Dawn prayer (Fajr)</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Syuruk</td><td class="px-4 py-2 text-gray-600">Sunrise</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Dhuha</td><td class="px-4 py-2 text-gray-600">Forenoon optional prayer (calculated: syuruk + ⅓(syuruk−subuh))</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Zohor</td><td class="px-4 py-2 text-gray-600">Noon prayer (Zuhr)</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Asar</td><td class="px-4 py-2 text-gray-600">Afternoon prayer (Asr)</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Maghrib</td><td class="px-4 py-2 text-gray-600">Sunset prayer</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Isyak</td><td class="px-4 py-2 text-gray-600">Night prayer (Isha)</td></tr>
                </tbody>
            </table>

            <!-- Zones Reference -->
            <h2 class="mt-10 text-xl font-semibold text-gray-900">Zone Codes</h2>
            <table class="mt-4 w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-500">State</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500">Codes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-4 py-2 font-medium">Johor</td><td class="px-4 py-2 text-gray-600">JHR01, JHR02, JHR03, JHR04</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Kedah</td><td class="px-4 py-2 text-gray-600">KDH01 – KDH07</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Kelantan</td><td class="px-4 py-2 text-gray-600">KTN01, KTN02</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Melaka</td><td class="px-4 py-2 text-gray-600">MLK01</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Negeri Sembilan</td><td class="px-4 py-2 text-gray-600">NGS01, NGS02, NGS03</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Pahang</td><td class="px-4 py-2 text-gray-600">PHG01 – PHG07</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Perak</td><td class="px-4 py-2 text-gray-600">PRK01 – PRK07</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Perlis</td><td class="px-4 py-2 text-gray-600">PLS01</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Pulau Pinang</td><td class="px-4 py-2 text-gray-600">PNG01</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Sabah</td><td class="px-4 py-2 text-gray-600">SBH01 – SBH09</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Sarawak</td><td class="px-4 py-2 text-gray-600">SWK01 – SWK09</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Selangor</td><td class="px-4 py-2 text-gray-600">SGR01, SGR02, SGR03</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Terengganu</td><td class="px-4 py-2 text-gray-600">TRG01 – TRG04</td></tr>
                    <tr><td class="px-4 py-2 font-medium">Wilayah Persekutuan</td><td class="px-4 py-2 text-gray-600">WLY01, WLY02</td></tr>
                </tbody>
            </table>

            <p class="mt-10 text-sm text-gray-400">Data sourced from JAKIM's e-Solat portal. Dhuha is calculated locally as syuruk + ⅓(syuruk − subuh).</p>
        </main>
    </div>
</body>
</html>
