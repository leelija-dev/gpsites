<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetRequest extends Page
{
    protected string $view = 'filament-panels::pages.auth.password-reset.request';
    protected static bool $shouldRegisterNavigation = false;

    public ?string $email = null;

    public function mount(): void
    {
        if (auth('admin')->check()) {
            redirect('/admin');
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->autocomplete('email'),
            ]);
    }

    public function request(): void
    {
        $data = $this->form->getState();

        $status = Password::broker('admins')->sendResetLink(
            ['email' => $data['email']]
        );

        if ($status === Password::RESET_LINK_SENT) {
            Notification::make()
                ->title('Password reset link sent!')
                ->body('Please check your email for the password reset link.')
                ->success()
                ->send();

            $this->form->fill();
        } else {
            Notification::make()
                ->title('Unable to send password reset link')
                ->body('Please check your email address and try again.')
                ->danger()
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('request')
                ->label('Send Password Reset Link')
                ->action('request'),
        ];
    }
}