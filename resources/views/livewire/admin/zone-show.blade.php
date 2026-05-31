<div>
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.zones') }}" wire:navigate class="text-sm text-gray-500 hover:text-gray-700">&larr; Back</a>
        <h1 class="text-2xl font-bold text-gray-900">{{ $zone->code }} — {{ $zone->state }}</h1>
    </div>
    <p class="mt-1 text-sm text-gray-500">{{ $zone->description }}</p>

    <h2 class="mt-8 text-lg font-semibold text-gray-900">Prayer Times</h2>
    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imsak</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subuh</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Syuruk</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zohor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asar</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Maghrib</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Isyak</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dhuha</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($prayerTimes as $pt)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $pt->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->imsak->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->subuh->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->syuruk->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->zohor->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->asar->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->maghrib->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->isyak->format('H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $pt->dhuha->format('H:i') }}</td>
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
