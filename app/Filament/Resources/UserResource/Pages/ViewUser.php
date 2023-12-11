<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $navigationLabel = 'Profile';

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->slideOver()
                ->modalHeading(fn():string => $this->record->fullname.'\'s'.' '.'Profile settings'),
        ];
    }
}
