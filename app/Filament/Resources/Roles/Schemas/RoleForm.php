<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            TextInput::make('name')
                ->required()
                ->unique(ignoreRecord: true),

            CheckboxList::make('permissions')
                ->relationship('permissions', 'name')
                ->columns(2)
                ->searchable()
                ->label('Assign Permissions'),

            Select::make('guard_name')
                ->options([
                    'web' => 'Web (Frontend Users)',
                    'admin' => 'Admin (Filament Admins)',
                ])
                ->default('admin') // or 'web'
                ->required()
        ]);
    }
}
