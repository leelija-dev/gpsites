<?php

namespace App\Filament\Resources\Users\Schemas;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')
                 //->label('User Name')
                 ->label(fn () => new HtmlString('User Name<sup style="color:red">*</sup>'))
                 ->placeholder('Enter user name')
                 ->rules([
                         'required'
                     ])
                     ->validationMessages([
                         'required' => 'The user name is can not be blank.',
                         
                     ]),
                 TextInput::make('email')
                    ->label(fn () => new HtmlString('Email<sup style="color:red">*</sup>'))
                     //->label('Email')
                     ->placeholder('Enter email address')
                     ->rules([
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
