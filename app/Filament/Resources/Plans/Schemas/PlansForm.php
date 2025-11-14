<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\HtmlString;

class PlansForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                ->label(fn () => new HtmlString('Name<sup style="color:red">*</sup>'))
                //->required()
                ->rules([
                    'required'
                ])
                ->validationMessages([
                    'required' => 'Plan name can not be blank!',
                ]),
                TextInput::make('slug')//->required(),
                 ->label(fn () => new HtmlString('Slug<sup style="color:red">*</sup>'))
                ->rules([
                    'required'
                ])
                ->validationMessages([
                    'required' => 'Slug can not be blank!',
                ]),

                TextInput::make('price')//->required(),
                    ->label(fn () => new HtmlString('Price<sup style="color:red">*</sup>'))
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Price can not be blank!',
                    ]),

                TextInput::make('description'),

                TextInput::make('duration')//->required(),
                    ->label(fn () => new HtmlString('Duration<sup style="color:red">*</sup>'))
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Duration can not be blank!',
                    ]),
                
                TextInput::make('mail_available')//->required(),
                    ->label(fn () => new HtmlString('Mail Available<sup style="color:red">*</sup>'))
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Mail Available can not be blank!',
                    ]),
                // TextInput::make('is_active')->required(),
                // Repeater::make('features')
                //     ->label('Plan Features')
                //     ->schema([
                //         TextInput::make('feature')
                //             ->label('Feature Name')
                //             ->required(),
                //     ])
                //     ->createItemButtonLabel('Add More Feature')
                //     ->columns(1)
                //     ->minItems(1)
                //     ->required(),

                Repeater::make('features')
                    ->label('Plan Features')
                    ->schema([
                        \Filament\Forms\Components\Hidden::make('id'),
                        \Filament\Forms\Components\TextInput::make('feature')
                            ->label('Feature Name'),
                    ])
                    ->createItemButtonLabel('Add More Feature')
                    ->columns(1)
                  

            ]);
    }
}
