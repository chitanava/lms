<?php

namespace App\Filament\Resources;

use App\Enums\CourseStatus;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use Filament\Forms\Components\Group;
use Guava\Filament\NestedResources\Resources\NestedResource;
use App\Traits\RelationManagerBreadcrumbs;
use Illuminate\Support\Str;

class CourseResource extends NestedResource
{
    use RelationManagerBreadcrumbs;

    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 0;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\MarkdownEditor::make('description')
                                    ->required()
                                    ->columnSpan('full'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->hiddenLabel()
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(2),

                Forms\Components\Section::make('Period')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),

                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->after('start_date'),
                    ])
                    ->collapsible()
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort',)
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('period')
                    ->getStateUsing(fn (Course $record): string => self::getDuration($record))
                    ->sortable(true, fn ($query, $direction) => $query->orderByRaw('end_date - start_date ' . $direction)),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn (Course $record): string => self::getStatus($record)->getLabel())
                    ->color(fn (Course $record): string => self::getStatus($record)->getColor()),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('start_date'),
                        Forms\Components\DatePicker::make('end_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['end_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['start_date'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make('Begin on ' . Carbon::parse($data['start_date'])->toFormattedDateString())
                                ->removeField('start_date');
                        }

                        if ($data['end_date'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make('End by ' . Carbon::parse($data['end_date'])->toFormattedDateString())
                                ->removeField('end_date');
                        }

                        return $indicators;
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Course')
                    ->icon('heroicon-o-academic-cap')
                    ->iconColor('primary')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\Grid::make(3)
                                ->schema([
                                    Infolists\Components\Group::make([
                                        Infolists\Components\TextEntry::make('title'),
                                    ]),

                                    Infolists\Components\Group::make([
                                        Infolists\Components\TextEntry::make('start_date')
                                            ->date(),

                                        Infolists\Components\TextEntry::make('end_date')
                                            ->date(),
                                    ]),

                                    Infolists\Components\Group::make([
                                        Infolists\Components\TextEntry::make('Period')
                                            ->getStateUsing(fn (Course $record) => self::getDuration($record)),

                                        Infolists\Components\TextEntry::make('status')
                                            ->badge()
                                            ->getStateUsing(fn (Course $record): string => self::getStatus($record)->getLabel())
                                            ->color(fn (Course $record): string => self::getStatus($record)->getColor()),
                                    ])
                                ]),

                            Infolists\Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->circular()
                                ->grow(false)
                        ])->from('lg'),
                    ]),

                Infolists\Components\Section::make('Description')
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TopicsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getDuration(Course $record): string
    {
        $duration = $record->start_date->diff($record->end_date);

        return $duration->days . ' ' . ($duration->days === 1 ? 'day' : 'days');
    }

    public static function getStatus(Course $record): CourseStatus
    {
        if ($record->end_date->isPast())
            return CourseStatus::Ended;

        if ($record->start_date->isFuture())
            return CourseStatus::NotStarted;

        return CourseStatus::Active;
    }

}
