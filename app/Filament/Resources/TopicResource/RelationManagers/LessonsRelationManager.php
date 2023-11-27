<?php

namespace App\Filament\Resources\TopicResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource;
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
            ->defaultSort('sort', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('is_visible')
                    ->query(fn (Builder $query): Builder => $query->where('is_visible', true)),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Lesson')
                        ->icon('heroicon-o-book-open')
                        ->iconColor('primary')
                        ->schema([
                            \Filament\Infolists\Components\Group::make([
                                \Filament\Infolists\Components\TextEntry::make('title'),
                            ]),
        
                            \Filament\Infolists\Components\IconEntry::make('is_visible')
                                ->label('Visibility')
                                ->boolean(),
                        ])
                        ->columns(2),
        
                        \Filament\Infolists\Components\Section::make('Topic')
                            ->icon('heroicon-o-hashtag')
                            ->schema([
                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('topic.title'),
                                ]),
        
                                \Filament\Infolists\Components\IconEntry::make('topic.is_visible')
                                    ->label('Visibility')
                                    ->boolean(),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(),
        
                        \Filament\Infolists\Components\Section::make('Course')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                \Filament\Infolists\Components\Grid::make(3)
                                    ->schema([
                                        \Filament\Infolists\Components\Group::make([
                                            \Filament\Infolists\Components\TextEntry::make('topic.course.title')
                                                ->label('Title'),
                                        ]),
        
                                        \Filament\Infolists\Components\Group::make([
                                            \Filament\Infolists\Components\TextEntry::make('topic.course.start_date')
                                                ->label('Start date')
                                                ->date(),
        
                                            \Filament\Infolists\Components\TextEntry::make('topic.course.end_date')
                                                ->label('End date')
                                                ->date(),
                                        ]),
        
                                        \Filament\Infolists\Components\Group::make([
                                            \Filament\Infolists\Components\TextEntry::make('Period')
                                                ->getStateUsing(fn (\App\Models\Lesson $record) => CourseResource::class::getDuration($record->topic->course)),
        
                                            \Filament\Infolists\Components\TextEntry::make('status')
                                                ->label('Status')
                                                ->badge()
                                                ->getStateUsing(fn (\App\Models\Lesson $record): string => CourseResource::class::getStatus($record->topic->course)->getLabel())
                                                ->color(fn (\App\Models\Lesson $record): string => CourseResource::class::getStatus($record->topic->course)->getColor()),
                                        ])
                                    ]),
                            ])
                            ->collapsible()
                            ->collapsed(),
                    ])
                    ->extraModalFooterActions([
                        \Filament\Actions\Action::make('Edit lesson')
                            ->url(fn (\App\Models\Lesson $record): string =>
                            route(
                                'filament.admin.resources.courses.topics.lessons.edit',
                                [
                                    'courseRecord' => $record->topic->course->id,
                                    'topicRecord' => $record->topic->id,
                                    'record' => $record->id
                                ]
                            ))
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
