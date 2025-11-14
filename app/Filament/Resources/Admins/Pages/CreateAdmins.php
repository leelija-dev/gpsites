<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmins extends CreateRecord
{
    protected static string $resource = AdminsResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
