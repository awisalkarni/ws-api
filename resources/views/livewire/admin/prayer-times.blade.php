<div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Prayer Times</h1>
        <button wire:click="sync"
                wire:loading.attr="disabled"
                wire:target="sync"
                class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="sync">Sync Now</span>
            <span wire:loading wire:target="sync">Syncing...</span>
        </button>
    </div>

    <div class="mt-4 flex gap-4">
        <div>
            <label for="searchDate" class="block text-xs font-medium text-gray-500">Date</label>
            <input type="date" wire:model.live="searchDate" id="searchDate"
                   class="mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
        </div>
        <div>
            <label for="zoneFilter" class="block text-xs font-medium text-gray-500">Zone</label>
            <select wire:model.live="zoneFilter" id="zoneFilter"
                    class="mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                <option value="">All Zones</option>
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subuh</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zohor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asar</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Maghrib</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Isyak</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($prayerTimes as $pt)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $pt->zone->code }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->subuh->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->zohor->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->asar->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->maghrib->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->isyak->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('admin.prayer-times.edit', $pt) }}" wire:navigate
                               class="text-gray-600 hover:text-gray-900">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $prayerTimes->links() }}
    </div>
</div>
