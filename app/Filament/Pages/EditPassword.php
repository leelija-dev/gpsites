<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPassword extends Page
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.edit-password';
    protected static ?string $title = 'Change Password';
    
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar
    protected static ?string $slug = 'profile/password'; // URL path

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('current_password')
                ->label('Current Password')
                ->password()
                ->revealable() 
                ->required(),

            TextInput::make('new_password')
                ->label('New Password')
                ->password()
                ->revealable() 
                ->required(),

            TextInput::make('new_password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->revealable() 
                ->same('new_password')
                ->required(),
        ];
    }

    public function save(): void
    {
        $user = Auth::guard('admin')->user();

        // Check if current password matches
        if (!Hash::check($this->form->getState()['current_password'], $user->password)) {
            Notification::make()
                ->title('Current password is incorrect')
                ->danger()
                ->send();
            return;
        }

        // Update password
        $user->password = $this->form->getState()['new_password'];
        $user->save();

        Notification::make()
            ->title('Password updated successfully!')
            ->success()
            ->send();

        $this->redirect(url('admin/update-profile'));
    }
}
