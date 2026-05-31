<div>
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.prayer-times') }}" wire:navigate class="text-sm text-gray-500 hover:text-gray-700">&larr; Back</a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Prayer Time — {{ $prayerTime->zone->code }} {{ $prayerTime->date->format('Y-m-d') }}</h1>
    </div>

    <div class="mt-6 max-w-lg rounded-lg bg-white p-6 shadow-sm">
        <form wire:submit="save" class="flex flex-col gap-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-900">Date</label>
                <input type="date" wire:model="date" id="date" required
                       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                @error('date') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="imsak" class="block text-sm font-medium text-gray-900">Imsak</label>
                    <input type="time" wire:model="imsak" id="imsak" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('imsak') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="subuh" class="block text-sm font-medium text-gray-900">Subuh</label>
                    <input type="time" wire:model="subuh" id="subuh" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('subuh') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="syuruk" class="block text-sm font-medium text-gray-900">Syuruk</label>
                    <input type="time" wire:model="syuruk" id="syuruk" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('syuruk') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="zohor" class="block text-sm font-medium text-gray-900">Zohor</label>
                    <input type="time" wire:model="zohor" id="zohor" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('zohor') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="asar" class="block text-sm font-medium text-gray-900">Asar</label>
                    <input type="time" wire:model="asar" id="asar" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('asar') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="maghrib" class="block text-sm font-medium text-gray-900">Maghrib</label>
                    <input type="time" wire:model="maghrib" id="maghrib" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('maghrib') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="isyak" class="block text-sm font-medium text-gray-900">Isyak</label>
                    <input type="time" wire:model="isyak" id="isyak" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('isyak') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="dhuha" class="block text-sm font-medium text-gray-900">Dhuha</label>
                    <input type="time" wire:model="dhuha" id="dhuha" required
                           class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                    @error('dhuha') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.prayer-times') }}" wire:navigate
                   class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
