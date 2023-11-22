<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopicResource\Pages;
use App\Filament\Resources\TopicResource\RelationManagers;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Guava\Filament\NestedResources\Resources\NestedResource;
use Guava\Filament\NestedResources\Ancestor;
use App\Traits\RelationManagerBreadcrumbs;

class TopicResource extends NestedResource
{
    use RelationManagerBreadcrumbs;

    protected static ?string $model = Topic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make([
                    \Filament\Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),

                    \Filament\Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(ignoreRecord: true),
                ])->columns(2),

                \Filament\Forms\Components\Section::make('Status')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_visible')
                            ->live()
                            ->helperText(function (\Filament\Forms\Get $get) {
                                if ($get('is_visible')) return 'This topic will be visible.';

                                return 'This topic will be hidden.';
                            })
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make([
                    \Filament\Infolists\Components\Group::make([
                        \Filament\Infolists\Components\TextEntry::make('title'),
                    ]),

                    \Filament\Infolists\Components\IconEntry::make('is_visible')
                        ->boolean(),
                ])->columns(3),

                \Filament\Infolists\Components\Section::make('Course')
                    ->schema([
                        \Filament\Infolists\Components\Grid::make(3)
                            ->schema([
                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('course.title')
                                        ->label('Title'),
                                ]),

                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('course.start_date')
                                        ->label('Start date')
                                        ->date(),

                                    \Filament\Infolists\Components\TextEntry::make('course.end_date')
                                        ->label('End date')
                                        ->date(),
                                ]),

                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\TextEntry::make('Period')
                                        ->getStateUsing(fn (Topic $record) => CourseResource::class::getDuration($record->course)),

                                    \Filament\Infolists\Components\TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->getStateUsing(fn (Topic $record): string => CourseResource::class::getStatus($record->course)->getLabel())
                                        ->color(fn (Topic $record): string => CourseResource::class::getStatus($record->course)->getColor()),
                                ])
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        // This is just a simple configuration with a few helper methods
        return Ancestor::make(
            CourseResource::class, // Parent Resource Class
            // Optionally you can pass a relationship name, if it's non-standard. The plugin will try to guess it otherwise
        );
    }

    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ListTopics::route('/'),
            'create' => Pages\CreateTopic::route('/create'),
            'view' => Pages\ViewTopic::route('/{record}'),
            'edit' => Pages\EditTopic::route('/{record}/edit'),
        ];
    }
}
