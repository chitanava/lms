<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\Filament\NestedResources\Pages\NestedCreateRecord;

class CreateLesson extends NestedCreateRecord
{
    protected static string $resource = LessonResource::class;
}
