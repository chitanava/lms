<?php

namespace App\Filament\Resources\TopicResource\Pages;

use App\Filament\Resources\TopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Guava\Filament\NestedResources\Pages\NestedViewRecord;

class ViewTopic extends NestedViewRecord
{
    protected static string $resource = TopicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
