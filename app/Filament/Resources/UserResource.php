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
use Filament\Resources\Concerns\HasTabs;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Filament\Infolists;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name'];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Status'))
                    ->schema([
                        Forms\Components\Toggle::make('filament_user')
                            ->live()
                            ->helperText(fn($record):string|Htmlable => __('Enabling this option allows the user to access Filament admin panel.')),

                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visible(fn(Forms\Get $get) => $get('filament_user'))
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name)),
                    ])
                    ->description(__('To empower the user, provide them with access to the panel.')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('Name'))
                    ->sortable()
                    ->formatStateUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(query: fn(Builder $query, string $search): Builder => $query
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->date(),

                Tables\Columns\TextColumn::make('verified')
                    ->label(false)
                    ->badge()
                    ->formatStateUsing(fn(bool $state):string => $state ? __('Verified') : '')
                    ->color('success'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->hidden(fn($livewire) => $livewire->activeTab === 'participants'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),

                Tables\Filters\SelectFilter::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                    ->searchable()
                    ->preload()
                    ->placeholder(__('Select an option'))
                    ->hidden(function(Pages\ListUsers $livewire){
                        return $livewire->activeTab === 'participants';
                    })
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['values'] ?? null,
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
                    ->iconButton()
                    ->label(__('Settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->slideOver()
                    ->modalHeading(fn($record):string => $record->fullname.'\'s'.' '.__('Profile settings')),

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

                            Infolists\Components\TextEntry::make('email'),
                        ]),

                        Infolists\Components\Group::make([
                            Infolists\Components\IconEntry::make('verified')
                                ->boolean(),

                            Infolists\Components\IconEntry::make('filament_user')
                                ->boolean(),

                            Infolists\Components\TextEntry::make('roles.name')
                                ->badge()
                                ->formatStateUsing(fn ($state): string => Str::headline($state))
                                ->visible(fn($record) => $record->filament_user),
                        ]),

                        Infolists\Components\Group::make([
                            Infolists\Components\TextEntry::make('created_at')
                                ->date(),
                        ]),
                    ])
                    ->columns(3),
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
//            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
