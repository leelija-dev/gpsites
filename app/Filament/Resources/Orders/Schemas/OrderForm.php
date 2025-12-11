<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use App\Models\MailAvailable;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('expire_at')
                ->label('Expire Date')
                ->rules(['required'])
                ->validationMessages([
                        'required'=>'Duration can not be blank!',
                ]),
                TextInput::make('mail_available.total_mail')
                    ->label('Total Mail')
                    ->numeric()
                    ->required()
                    ->validationMessages([
                        'required' => 'Total mail is required',
                        'numeric' => 'Must be a number'
                    ]),
                    
                TextInput::make('mail_available.available_mail')
                    ->label('Available Mail')
                    ->numeric()
                    ->required()
                    ->validationMessages([
                        'required' => 'Available mail is required',
                        'numeric' => 'Must be a number'
                    ]),
                    Checkbox::make('send_mail')
                        ->label('send update expire date mail to user')
                        ->default(false),
            ]);
    }
}
