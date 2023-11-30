<?php

namespace App\Filament\Resources\TopicResource\RelationManagers;

use App\Models\Lesson;
use Filament\Actions;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource;
use Filament\Infolists;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Guava\Filament\NestedResources\RelationManagers\NestedRelationManager;

class LessonsRelationManager extends NestedRelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->infolist([
                        Infolists\Components\Section::make('Lesson')
                        ->icon('heroicon-o-book-open')
                        ->iconColor('primary')
                        ->schema([
                            Infolists\Components\Group::make([
                                Infolists\Components\TextEntry::make('title'),
                            ]),

                            Infolists\Components\IconEntry::make('is_visible')
                                ->label('Visibility')
                                ->boolean(),
                        ])
                        ->columns(),

                        Infolists\Components\Section::make('Topic')
                            ->icon('heroicon-o-hashtag')
                            ->schema([
                                Infolists\Components\Group::make([
                                    Infolists\Components\TextEntry::make('topic.title'),
                                ]),

                                Infolists\Components\IconEntry::make('topic.is_visible')
                                    ->label('Visibility')
                                    ->boolean(),
                            ])
                            ->columns()
                            ->collapsible()
                            ->collapsed(),

                        Infolists\Components\Section::make('Course')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Infolists\Components\Grid::make(3)
                                    ->schema([
                                        Infolists\Components\Group::make([
                                            Infolists\Components\TextEntry::make('topic.course.title')
                                                ->label('Title'),
                                        ]),

                                        Infolists\Components\Group::make([
                                            Infolists\Components\TextEntry::make('topic.course.start_date')
                                                ->label('Start date')
                                                ->date(),

                                            Infolists\Components\TextEntry::make('topic.course.end_date')
                                                ->label('End date')
                                                ->date(),
                                        ]),

                                        Infolists\Components\Group::make([
                                            Infolists\Components\TextEntry::make('Period')
                                                ->getStateUsing(fn (Lesson $record) => CourseResource::class::getDuration($record->topic->course)),

                                            Infolists\Components\TextEntry::make('status')
                                                ->label('Status')
                                                ->badge()
                                                ->getStateUsing(fn (Lesson $record): string => CourseResource::class::getStatus($record->topic->course)->getLabel())
                                                ->color(fn (Lesson $record): string => CourseResource::class::getStatus($record->topic->course)->getColor()),
                                        ])
                                    ]),
                            ])
                            ->collapsible()
                            ->collapsed(),
                    ])
                    ->extraModalFooterActions([
                        Actions\Action::make('Edit lesson')
                            ->url(fn (Lesson $record): string =>
                            route('filament.admin.resources.courses.topics.lessons.edit', ['courseRecord' => $record->topic->course->id, 'topicRecord' => $record->topic->id, 'record' => $record->id]))
                    ])
                    ->slideOver()
                    ->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordAction(Tables\Actions\ViewAction::class)
            ->recordUrl(null);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
