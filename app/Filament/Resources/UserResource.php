<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? __('filament-shield::filament-shield.nav.group')
            : '';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
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
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::headline($state)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                    ->searchable()
                    ->preload()
                    ->placeholder('Select an option')
                    ->query(fn(Builder $query, array $data): Builder =>
                            $query
                                ->when(
                                    $data['values'],
                                    fn(Builder $query, $roleIds): Builder =>
                                        $query->whereHas(
                                            'roles',
                                            fn($query) => $query->whereIn('id', $roleIds)
                                        )
                                )
                    )
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['values'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(
                                'Roles: ' .
                                DB::table('roles')
                                    ->whereIn(
                                        'id',
                                        $data['values'])
                                    ->orderByRaw("FIELD(id, ".implode(',', $data['values']).")")
                                    ->get()
                                    ->map(fn($item) => Str::headline($item->name))->implode(' & ')
                            );
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
