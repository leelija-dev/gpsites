<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    //->required()
                    ->label('Permission Name')
                    ->rules(['required','unique:permissions,name'])
                    ->validationMessages([
                        'required' => 'Permission name can not be blank!',
                        'unique' => 'This permission name is already taken!',
                    ])
            ]);
    }
}
