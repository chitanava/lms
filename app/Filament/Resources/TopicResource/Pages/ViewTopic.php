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
            Actions\Action::make('Edit')
                ->modalHeading(fn(): string => 'Edit '.$this->record->title)
                ->fillForm(fn ($record): array => $record->toArray())
                ->form(TopicResource::topicForm())
                ->modalSubmitActionLabel('Save changes')
                ->slideOver()
                ->extraModalFooterActions(fn ($action): array => [
                    Actions\DeleteAction::make()
                        ->successRedirectUrl(route('filament.admin.resources.courses.view', ['record' => $this->record->course->id]))
                        ->extraAttributes([
                            'style' => 'order:999;',
                            'class' => 'ml-auto'
                        ]),
                ])
                ->action(function (array $data, $record, Actions\Action $action): void {
                    $record->update($data);
                    $action->successNotificationTitle('Saved')->sendSuccessNotification();
                })
        ];
    }
}
