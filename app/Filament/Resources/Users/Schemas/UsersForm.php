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
                 TextInput::make('name')
                 ->label('User Name')
                 ->rules([
                         'required'
                     ])
                     ->validationMessages([
                         'required' => 'The user name is can not be blank.',
                         
                     ]),
                 TextInput::make('email')->label('Email')->rules([
                        'required',
                        'email',
                        //'unique:users,email',
                    ])
                    ->validationMessages([
                        'required' => 'The email can not be blank.',
                        'email' => 'Please enter a valid email address.',
                        //'unique' => 'This email is already registered.',
                    ]),
            ]);
    }
}
