<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updatedActiveTab(): void
    {
        $this->resetPage();
        $this->dispatch('refreshComponent');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'filament_users' => Tab::make('Filament users')
                ->badge(User::query()->where('filament_user', '=', 1)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('filament_user', '=', 1)),
            'participants' => Tab::make('Participants')
                ->badge(User::query()->where('filament_user', '!=', 1)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('filament_user', '!=', 1)),
        ];
    }
}
