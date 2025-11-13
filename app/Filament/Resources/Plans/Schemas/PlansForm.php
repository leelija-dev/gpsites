<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PlansForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')->required(),
                TextInput::make('slug')->required(),
                TextInput::make('price')->required(),
                TextInput::make('description'),
                TextInput::make('duration')->required(),
                TextInput::make('mail_available')->required(),
                // TextInput::make('is_active')->required(),

            ]);
    }
}
