<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->getStateUsing(function (Course $record): string {
                        $duration = $record->start_date->diff($record->end_date);

                        return $duration->days . ' ' . ($duration->days === 1 ? 'day' : 'days');
                    })
                    ->sortable(true, fn ($query, $direction) => $query->orderByRaw('end_date - start_date ' . $direction)),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(function (Course $record): string {
                        if ($record->end_date->isPast())
                            return 'Ended';

                        if ($record->start_date->isFuture())
                            return 'Not started';

                        return 'Active';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Ended' => 'danger',
                        'Not started' => 'gray',
                        'Active' => 'success',
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
}
