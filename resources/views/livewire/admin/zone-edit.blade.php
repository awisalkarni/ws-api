<div>
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.zones') }}" wire:navigate class="text-sm text-gray-500 hover:text-gray-700">&larr; Back</a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Zone — {{ $zone->code }}</h1>
    </div>

    <div class="mt-6 max-w-lg rounded-lg bg-white p-6 shadow-sm">
        <form wire:submit="save" class="flex flex-col gap-4">
            <div>
                <label for="code" class="block text-sm font-medium text-gray-900">Code</label>
                <input type="text" wire:model="code" id="code" required maxlength="10"
                       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                @error('code') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="state" class="block text-sm font-medium text-gray-900">State</label>
                <input type="text" wire:model="state" id="state" required
                       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none">
                @error('state') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                <textarea wire:model="description" id="description" required rows="3"
                          class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-gray-500 focus:outline-none"></textarea>
                @error('description') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.zones') }}" wire:navigate
                   class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
