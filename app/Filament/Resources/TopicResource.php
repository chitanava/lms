<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopicResource\Pages;
use App\Filament\Resources\TopicResource\RelationManagers;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Guava\Filament\NestedResources\Resources\NestedResource;
use Guava\Filament\NestedResources\Ancestor;
use App\Traits\RelationManagerBreadcrumbs;
use Illuminate\Support\Str;

class TopicResource extends NestedResource
{
    use RelationManagerBreadcrumbs;

    protected static ?string $model = Topic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::topicForm());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Topic')
                    ->icon('heroicon-o-hashtag')
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

                \Filament\Infolists\Components\Section::make('Course')
                    ->icon('heroicon-o-academic-cap')
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
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LessonsRelationManager::class,
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(
            CourseResource::class,
        );
    }

    public static function getPages(): array
    {
        return [
//            'create' => Pages\CreateTopic::route('/create'),
            'view' => Pages\ViewTopic::route('/{record}'),
            'edit' => Pages\EditTopic::route('/{record}/edit'),
        ];
    }

    public static function topicForm(): array
    {
        return [
            Forms\Components\Section::make([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique(ignoreRecord: true),
            ])->columns(),

            Forms\Components\Section::make('Status')
                ->schema([
                    Forms\Components\Toggle::make('is_visible')
                        ->live()
                        ->helperText(function (Forms\Get $get) {
                            if ($get('is_visible')) return 'This topic will be visible.';

                            return 'This topic will be hidden.';
                        })
                ])
        ];
    }
}
