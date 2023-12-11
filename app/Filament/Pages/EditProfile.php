<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.edit-profile';

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->profileForm->fill($data);
    }

    public function saveProfile(): void
    {
        try {
            $data = $this->profileForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);

        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()?->send();
    }

    public function savePassword(): void
    {
        try {
            $data = $this->passwordForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);

        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()?->send();

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->passwordData['password'] = null;
        $this->passwordData['passwordConfirmation'] = null;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::pages/auth/edit-profile.notifications.saved.title');
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label(__('First name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label(__('Last name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }

    protected function getPasswordFormComponent(): Component
    {
        return \Rawilk\FilamentPasswordInput\Password::make('password')
            ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
            ->regeneratePassword()
            ->generatePasswordUsing(fn () => Str::password(12))
            ->notifyOnPasswordRegenerate(false)
            ->rule(Password::default())
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation');
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return \Rawilk\FilamentPasswordInput\Password::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
            ->visible(fn (Get $get): bool => filled($get('password')))
            ->dehydrated(false);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    protected function getForms(): array
    {
        return [
            'profileForm' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make(__('Profile Information'))
                            ->schema([
                                $this->getFirstNameFormComponent(),
                                $this->getLastNameFormComponent(),
                                $this->getEmailFormComponent(),
                            ])
                            ->description(__('Update your account\'s profile information and email address.'))
                            ->columns(2)
                            ->aside(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('profileData'),
            ),

            'passwordForm' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make(__('Update Password'))
                            ->schema([
                                $this->getPasswordFormComponent(),
                                $this->getPasswordConfirmationFormComponent(),
                            ])
                            ->description(__('To maintain the security of your account, it is recommended to use a long and random password.'))
                            ->columns(2)
                            ->aside(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('passwordData'),
            ),
        ];
    }

    protected function getProfileFormActions(): array
    {
        return [
            $this->getSaveProfileFormAction(),
        ];
    }

    protected function getPasswordFormActions(): array
    {
        return [
            $this->getSavePasswordFormAction(),
        ];
    }

    protected function getSaveProfileFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
            ->submit('saveProfile');
    }

    protected function getSavePasswordFormAction(): Action
    {
        return Action::make('save')
            ->label(__('Update password'))
            ->submit('savePassword')
            ->disabled(fn() => !filled($this->passwordData['password'] ?? null));
    }

    public function getFormActionsAlignment(): string | Alignment
    {
        return Alignment::End;
    }
}
