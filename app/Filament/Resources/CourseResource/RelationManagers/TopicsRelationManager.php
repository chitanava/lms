<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Filament\Resources\TopicResource;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Guava\Filament\NestedResources\RelationManagers\NestedRelationManager;
use Illuminate\Support\Str;

class TopicsRelationManager extends NestedRelationManager
{
    protected static string $relationship = 'topics';

    public function form(Form $form): Form
    {
        return TopicResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_visible')
                    ->query(fn (Builder $query): Builder => $query->where('is_visible', true)),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver(),

//                Tables\Actions\Action::make('New topic')
//                    ->modalHeading('Create topic')
//                    ->form(TopicResource::topicForm())
//                    ->modalSubmitActionLabel('Create')
//                    ->extraModalFooterActions(fn (Tables\Actions\Action $action): array => [
//                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])->label('Create & create another')
//                    ])
//                    ->slideOver()
//                    ->action(function (array $data, array $arguments, Tables\Actions\Action $action, Form $form): void {
//                        $this->getOwnerRecord()->topics()->create($data);
//                        $action->successNotificationTitle('Created')->sendSuccessNotification();
//
//                        if ($arguments['another'] ?? false) {
//                            $form->fill();
//                            $action->halt();
//                        }
//                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),

                Tables\Actions\Action::make('Edit')
                    ->icon('heroicon-s-pencil-square')
                    ->iconButton()
                    ->modalHeading(fn(Topic $record): string => 'Edit '.$record->title)
                    ->fillForm(fn (Topic $record): array => $record->toArray())
                    ->form(TopicResource::topicForm())
                    ->modalSubmitActionLabel('Save changes')
                    ->slideOver()
                    ->action(function (array $data, Topic $record, Tables\Actions\Action $action): void {
                        $record->update($data);
                        $action->successNotificationTitle('Saved')->sendSuccessNotification();
                    }),

                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
