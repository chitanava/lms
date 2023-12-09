<x-filament-panels::page>
    <x-filament-panels::form wire:submit="saveProfile">
        {{ $this->profileForm }}

        <x-filament-panels::form.actions
            :actions="$this->getProfileFormActions()"
        />
    </x-filament-panels::form>

    <x-filament-panels::form wire:submit="savePassword">
        {{ $this->passwordForm }}

        <x-filament-panels::form.actions
            :actions="$this->getPasswordFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
