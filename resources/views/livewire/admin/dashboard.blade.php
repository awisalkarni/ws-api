<div>
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

    <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Zones</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $zonesCount }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Prayer Time Records</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($prayerTimesCount) }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Latest Sync</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">
                @if ($latestSyncLog)
                    <span class="{{ $latestSyncLog->status === 'success' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $latestSyncLog->zone_code }} — {{ $latestSyncLog->status }}
                    </span>
                    <span class="block text-sm text-gray-500">{{ $latestSyncLog->created_at->diffForHumans() }}</span>
                @else
                    <span class="text-gray-400">No syncs yet</span>
                @endif
            </dd>
        </div>
    </dl>

    <h2 class="mt-8 text-lg font-semibold text-gray-900">Recent Sync Logs</h2>
    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Records</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($recentSyncLogs as $log)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $log->zone_code }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->year }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="{{ $log->status === 'success' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $log->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->records_created }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">No sync logs yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
