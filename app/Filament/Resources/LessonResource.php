<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Topic;
use App\Models\Lesson;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Guava\Filament\NestedResources\Ancestor;
use App\Filament\Resources\LessonResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LessonResource\RelationManagers;
use Guava\Filament\NestedResources\Resources\NestedResource;

class LessonResource extends NestedResource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Group::make([
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
                    ])
                        ->columns(2),

                    \Filament\Forms\Components\Section::make('Components')
                ])
                    ->columnSpan(2),


                \Filament\Forms\Components\Section::make('Status')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_visible')
                            ->live()
                            ->helperText(function (\Filament\Forms\Get $get) {
                                if ($get('is_visible')) return 'This lesson will be visible.';

                                return 'This lesson will be hidden.';
                            })
                    ])
                    ->columnSpan(1)
            ])
            ->columns(3);
    }

    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(
            TopicResource::class,
        );
    }

    public static function getPages(): array
    {
        return [
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}