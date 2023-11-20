<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CourseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CourseResource\RelationManagers;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Infolists\Components\TextEntry;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort', 'asc')
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->toggleable(isToggledHiddenByDefault: true),

                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                \Filament\Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('duration')
                    ->getStateUsing(fn (Course $record): string => self::getDuration($record))
                    ->sortable(true, fn ($query, $direction) => $query->orderByRaw('end_date - start_date ' . $direction)),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn (Course $record): string => self::getStatus($record))
                    ->color(fn (string $state): string => match ($state) {
                        __('status.ended') => 'danger',
                        __('status.not_started') => 'gray',
                        __('status.active') => 'success',
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('start_date'),
                        \Filament\Forms\Components\DatePicker::make('end_date'),
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
                            $indicators[] = \Filament\Tables\Filters\Indicator::make('Begin on ' . \Carbon\Carbon::parse($data['start_date'])->toFormattedDateString())
                                ->removeField('start_date');
                        }

                        if ($data['end_date'] ?? null) {
                            $indicators[] = \Filament\Tables\Filters\Indicator::make('End by ' . \Carbon\Carbon::parse($data['end_date'])->toFormattedDateString())
                                ->removeField('end_date');
                        }

                        return $indicators;
                    })
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make()
                    ->schema([
                        \Filament\Infolists\Components\Split::make([
                            \Filament\Infolists\Components\Grid::make(2)
                                ->schema([
                                    \Filament\Infolists\Components\Group::make([
                                        \Filament\Infolists\Components\TextEntry::make('title'),
                                        \Filament\Infolists\Components\TextEntry::make('slug'),
                                        \Filament\Infolists\Components\TextEntry::make('status')
                                            ->badge()
                                            ->getStateUsing(fn (Course $record): string => self::getStatus($record))
                                            ->color(fn (string $state): string => match ($state) {
                                                __('status.ended') => 'danger',
                                                __('status.not_started') => 'gray',
                                                __('status.active') => 'success',
                                            }),
                                    ]),
                                    \Filament\Infolists\Components\Group::make([
                                        \Filament\Infolists\Components\TextEntry::make('start_date')
                                            ->date(),
                                        \Filament\Infolists\Components\TextEntry::make('end_date')
                                            ->date(),
                                        \Filament\Infolists\Components\TextEntry::make('duration')
                                            ->getStateUsing(fn (Course $record) => self::getDuration($record)),
                                    ]),
                                ]),
                            \Filament\Infolists\Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),
                \Filament\Infolists\Components\Section::make('Description')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('description')
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
            //
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

    private static function getDuration(Course $record): string
    {
        $duration = $record->start_date->diff($record->end_date);

        return $duration->days . ' ' . ($duration->days === 1 ? 'day' : 'days');
    }

    private static function getStatus(Course $record): string
    {
        if ($record->end_date->isPast())
            return __('status.ended');

        if ($record->start_date->isFuture())
            return __('status.not_started');

        return __('status.active');
    }
}
