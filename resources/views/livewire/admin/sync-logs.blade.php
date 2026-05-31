<div>
    <h1 class="text-2xl font-bold text-gray-900">Sync Logs</h1>

    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Records</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Error</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($syncLogs as $log)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $log->zone_code }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->year }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="{{ $log->status === 'success' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $log->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->records_created }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $log->error_message }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $syncLogs->links() }}
    </div>
</div>
