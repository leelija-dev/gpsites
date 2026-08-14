<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Role;
class EditAdmins extends EditRecord
{
    protected static string $resource = AdminsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    /**
     * Load existing Spatie role into the form.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $role = $this->record->roles()
            ->where('guard_name', 'admin')
            ->first();

        $data['role_id'] = $role?->id;

        return $data;
    }

    /**
     * role_id is not an admins table column.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['role_id']);

        return $data;
    }

    /**
     * Update Spatie role after Admin is saved.
     */
    protected function afterSave(): void
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
