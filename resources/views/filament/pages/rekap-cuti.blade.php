<x-filament-panels::page>
    <div class="flex flex-col gap-4">
        {{-- Filter Section --}}
        <x-filament::section class="fi-section-compact">
            <form wire:submit.prevent="$refresh" class="flex flex-col md:flex-row items-end gap-3">
                <div class="flex-1">
                    {{ $this->form }}
                </div>
                
                <div class="pb-[2px]">
                    <x-filament::button type="submit" wire:click="$refresh" icon="heroicon-m-magnifying-glass" class="h-10">
                        Tampilkan
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Native Filament Table --}}
        {{-- Ini akan merender tabel canggih dengan pagination & sorting --}}
        {{ $this->table }}

    </div>
</x-filament-panels::page>
