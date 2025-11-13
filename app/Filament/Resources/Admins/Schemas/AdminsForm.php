<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class AdminsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // optional but makes intent clear
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->columnSpanFull(),

                // Toggle::make('status')
                //     ->columnSpanFull(),
            ]);
    }
}
