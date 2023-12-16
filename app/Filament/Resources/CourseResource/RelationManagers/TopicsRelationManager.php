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
                Tables\Actions\CreateAction::make()
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->slideOver(),

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
