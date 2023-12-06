<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Course;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Filament\Infolists;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'full_name';

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
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('filament_user')
                            ->live(),

                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visible(fn(Forms\Get $get) => $get('filament_user'))
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name)),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('filament_user')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::headline($state)),
            ])
            ->filters([
                Tables\Filters\Filter::make('filament_user')
                    ->query(fn (Builder $query): Builder => $query->where('filament_user', true)),

                Tables\Filters\SelectFilter::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                    ->searchable()
                    ->preload()
                    ->placeholder('Select an option')
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['values'],
                            fn (Builder $query, $roleIds): Builder => $query->whereHas(
                                'roles',
                                fn ($query) => $query->whereIn('id', $roleIds)
                            )
                        )
                    )
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['values'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(
                                'Roles: '.
                                DB::table('roles')
                                    ->whereIn(
                                        'id',
                                        $data['values'])
                                    ->orderByRaw('FIELD(id, '.implode(',', $data['values']).')')
                                    ->get()
                                    ->map(fn ($item) => Str::headline($item->name))->implode(' & ')
                            );
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
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

    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('first_name'),
                            Infolists\Components\TextEntry::make('last_name'),
                        ]),

                        Infolists\Components\Group::make([
                            Infolists\Components\IconEntry::make('filament_user')
                                ->boolean(),
                            Infolists\Components\TextEntry::make('roles.name')
                                ->badge()
                                ->formatStateUsing(fn ($state): string => Str::headline($state)),
                        ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewUser::class,
            Pages\EditUser::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
