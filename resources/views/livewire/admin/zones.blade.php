<div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Zones</h1>
    </div>

    <div class="mt-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by code or state..."
               class="w-full max-w-sm rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
    </div>

    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">State</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prayer Times</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($zones as $zone)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $zone->code }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $zone->state }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ Str::limit($zone->description, 60) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $zone->prayer_times_count }}</td>
                        <td class="px-4 py-3 text-sm flex gap-2">
                            <a href="{{ route('admin.zones.show', $zone) }}" wire:navigate
                               class="text-gray-600 hover:text-gray-900">View</a>
                            <a href="{{ route('admin.zones.edit', $zone) }}" wire:navigate
                               class="text-gray-600 hover:text-gray-900">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $zones->links() }}
    </div>
</div>
