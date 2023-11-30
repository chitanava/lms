<?php

namespace App\Filament\Resources\TopicResource\Pages;

use App\Filament\Resources\TopicResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\Filament\NestedResources\Pages\NestedCreateRecord;

class CreateTopic extends NestedCreateRecord
{
    protected static string $resource = TopicResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();

        if ($maxSort = $record->course->topics()->max('sort'))
            $record->update(['sort' => $maxSort + 1]);
    }
}
