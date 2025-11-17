<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
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
                    //->label('Permission Name')
                    ->label(fn () => new HtmlString('Permission Name<sup style="color:red">*</sup>'))
                    ->placeholder('Enter permission name')
                    ->rules(['required','unique:permissions,name'])
                    ->validationMessages([
                        'required' => 'Permission name can not be blank!',
                        'unique' => 'This permission name is already taken!',
                    ])
            ]);
    }
}
