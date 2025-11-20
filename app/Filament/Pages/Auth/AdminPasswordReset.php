<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminPasswordReset extends Page
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.auth.password-reset';
    protected static bool $shouldRegisterNavigation = false;

    public ?string $token = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function mount(Request $request): void
    {
        $this->token = $request->query('token');
        $this->email = $request->query('email');
    }

    protected function getFormSchema(): array
    {
        return [
            // Remove the visible token field and use a hidden field instead
            Hidden::make('token')
                ->default($this->token),
            
            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->default($this->email)
                ->autocomplete('email'),
            
            TextInput::make('password')
                ->label('New Password')
                ->password()
                ->required()
                ->confirmed()
                ->minLength(8),
            
            TextInput::make('password_confirmation')
                ->label('Confirm New Password')
                ->password()
                ->required(),
        ];
    }

    public function resetPassword(): void
    {
        $data = $this->form->getState();

        $status = Password::broker('admins')->reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Notification::make()
                ->title('Password reset successfully!')
                ->body('You can now log in with your new password.')
                ->success()
                ->send();

            $this->redirect('/admin/login');
        } else {
            Notification::make()
                ->title('Password reset failed')
                ->body('The provided token is invalid or expired.')
                ->danger()
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('reset')
                ->label('Reset Password')
                ->action('resetPassword'),
        ];
    }
}