<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CourseResource;
use Illuminate\Database\Eloquent\Builder;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('status.all')),
            'not started' => Tab::make(__('status.not_started'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('start_date', '>', now())),
            'active' => Tab::make(__('status.active'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())),
            'ended' => Tab::make(__('status.ended'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('end_date', '<', now())),
        ];
    }
}
