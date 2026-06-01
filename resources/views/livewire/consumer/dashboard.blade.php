<div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    </div>

    <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Your API Key</dt>
            <dd class="mt-1">
                <div class="flex items-center gap-2">
                    <code class="flex-1 text-sm font-mono text-gray-900 break-all">{{ $user->api_key }}</code>
                    <button onclick="navigator.clipboard.writeText('{{ $user->api_key }}'); this.textContent='Copied!'; setTimeout(() => this.textContent='Copy', 2000);"
                            class="rounded border border-gray-300 px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 shrink-0">Copy</button>
                </div>
            </dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Account Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
        </div>
    </dl>

    <h2 class="mt-8 text-lg font-semibold text-gray-900">Quick Start</h2>
    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-lg bg-gray-800 p-4 text-white">
            <p class="text-xs text-gray-400 mb-2">Using Bearer Token:</p>
            <pre class="text-sm overflow-x-auto"><code>curl -H "Authorization: Bearer {{ $user->api_key }}" \
  https://ws-api.awislabs.com/api/v1/zones</code></pre>
        </div>
        <div class="rounded-lg bg-gray-800 p-4 text-white">
            <p class="text-xs text-gray-400 mb-2">Using Query Parameter:</p>
            <pre class="text-sm overflow-x-auto"><code>curl "https://ws-api.awislabs.com/api/v1/zones\
  ?api_key={{ $user->api_key }}"</code></pre>
        </div>
    </div>

    <p class="mt-6 text-sm text-gray-500">
        See the <a href="{{ route('docs') }}" class="font-medium text-gray-900 hover:underline">API documentation</a> for all available endpoints.
    </p>
</div>
