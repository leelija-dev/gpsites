<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    //  protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     // Example: Capitalize name before showing
    //     $data['name'] = strtoupper($data['name']);
    //     return $data;
    // }

    // // Modify form data before saving
    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     // Only hash password if it is filled
    //     if (!empty($data['password'])) {
    //         $data['password'] = bcrypt($data['password']);
    //     } else {
    //         // Remove password field so it does not overwrite existing password
    //         unset($data['password']);
    //     }

    //     return $data;
    // }
    // protected function getUserData(): \App\Models\User
    // {
    //     return $this->record; // this is automatically the User being edited
    // }

}
