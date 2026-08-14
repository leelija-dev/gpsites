<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminsResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;
class CreateAdmins extends CreateRecord
{
    protected static string $resource = AdminsResource::class;

     protected function mutateFormDataBeforeCreate(array $data): array
    {
        // role_id is not a column in admins table
        unset($data['role_id']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $roleId = $this->data['role_id'] ?? null;

        if ($roleId) {
            $role = Role::where('id', $roleId)
                ->where('guard_name', 'admin')
                ->first();

            if ($role) {
                $this->record->syncRoles([$role]);
            }
        }
    }
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
