<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Guava\Filament\NestedResources\Pages\NestedEditRecord;
use App\Traits\NestedEditRecordTrait;

class EditLesson extends NestedEditRecord
{
    protected static string $resource = LessonResource::class;

    use NestedEditRecordTrait;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
