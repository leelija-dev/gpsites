<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')->label('User Name')->required(),
                 TextInput::make('email')->label('Email')->required(),
            ]);
    }
}
