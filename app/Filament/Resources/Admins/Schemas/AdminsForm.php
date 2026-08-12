<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use App\Models\Role;

class AdminsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // optional but makes intent clear
            ->components([
                TextInput::make('name')
                    ->label(fn() => new HtmlString('Name<sup style="color:red">*</sup>'))
                    ->placeholder('Enter admin name')
                    ->rules(['required']) // server-side validation
                    ->validationMessages([
                        'required' => 'Name can not be blank!',
                    ]),


                TextInput::make('email')
                    ->label(fn() => new HtmlString('Email<sup style="color:red">*</sup>'))
                    ->placeholder('Enter email address')
                    ->rules([
                        'required',
                        'email',
                        'unique:admins,email'
                    ])
                    ->validationMessages([
                        'required' => 'Email can not be blank!',
                        'email' => 'Please provide a valid email address!',
                        'unique' => 'This email is already registered!',
                    ]),
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->imageEditor()
                    ->directory('')
                    ->disk('admin_image')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'image/jpg',
                    ]),

                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Enter description')
                    ->rows(5)
                    ->maxLength(500),

                TextInput::make('password')
                    ->label(fn() => new HtmlString('Password<sup style="color:red">*</sup>'))
                    ->placeholder('Enter password')
                    ->password()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Password can not be blank!',
                    ])
                    ->revealable()
                    ->columnSpanFull(),
                Radio::make('role_id')
                    ->label('Role')
                    ->options(
                        Role::query()
                            ->where('guard_name', 'admin')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->afterStateHydrated(function (Radio $component, $state, $record) {
                        // Edit page only
                        if ($record) {
                            $role = $record->roles()
                                ->where('guard_name', 'admin')
                                ->first();

                            $component->state($role?->id);
                        }
                    })
                    ->required()
                    ->validationMessages([
                        'required' => 'Please select a role!',
                    ]),
                // ->columnSpanFull();

                // Toggle::make('status')
                //     ->columnSpanFull(),
            ]);
    }
}
