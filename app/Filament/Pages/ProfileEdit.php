<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Page
{
    use InteractsWithForms;
   
    protected string $view = 'filament.pages.profile-edit';
    protected static ?string $title = 'Edit Profile';
    
    protected static bool $shouldRegisterNavigation = false; 
    protected  static ?string $slug = 'profile/edit'; 

     public array $formData = [];
    public function mount(): void
    {
        
        $admin = Auth::guard('admin')->user();
        // Initialize the form state manually
        $this->formData = [
            'name' => $admin->name,
            'email' => $admin->email,
        ];

        // Ensure Filament form is populated when the page mounts
        if (isset($this->form)) {
            $this->form->fill($this->formData);
        }
    }

    protected function getFormSchema(): array
    {
        $admin = Auth::guard('admin')->user();
        return [
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->reactive()
                ->default($admin?->name),

            TextInput::make('email')
                ->label('Email')
                ->required()
                ->reactive()
                ->default($admin?->email),
                
        ];
    }

    /**
     * Return the model to let Filament populate fields that match attribute names.
     */
    protected function getFormModel(): mixed
    {
        return Auth::guard('admin')->user();
    }

    public function save(): void
    {
        $admin = Auth::guard('admin')->user();

        // Validate before saving
        $data = $this->form->getState(); // use form state
        $admin->update($data);

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();

        $this->redirect(url('admin/update-profile'));
    }

    // protected function getFormState(): array
    // {
    //     // Make Filament use $formData as the state
    //     return $this->formData;
    // }
}