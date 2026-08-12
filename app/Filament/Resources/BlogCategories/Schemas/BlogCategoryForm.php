<?php

namespace App\Filament\Resources\BlogCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use App\Models\BlogCategory;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(fn() => new HtmlString('Name<sup style="color:red">*</sup>'))
                    ->placeholder('Enter name')
                    //->required()
                    ->rules([
                        'required'
                    ])
                    ->validationMessages([
                        'required' => 'Name can not be blank!',
                    ]),
                // TextInput::make('slug')
                //     ->placeholder('Enter category slug')
                //     ->label(fn() => new HtmlString(
                //         'Slug<sup style="color:red">*</sup>'
                //     ))
                //     ->required()
                //     ->unique(ignoreRecord: true)
                //     ->disabled(fn(string $operation): bool => $operation === 'edit')
                //     ->dehydrated()
                //     ->validationMessages([
                //         'required' => 'Slug can not be blank!',
                //     ]),
                TextInput::make('slug')
                ->placeholder('Enter category slug')
                ->label(fn() => new HtmlString(
                    'Slug<sup style="color:red">*</sup>'
                ))
                // ->required()
                ->rules([
                    'required'
                ])
                ->unique(ignoreRecord: true)
                ->disabled(fn(string $operation): bool => $operation === 'edit')
                ->dehydrated()
                ->formatStateUsing(fn($state) => $state ? Str::slug($state) : $state)
                ->dehydrateStateUsing(fn($state) => $state ? Str::slug($state) : $state)
                ->validationMessages([
                    'required' => 'Slug can not be blank!',
                ]),
                // ->columnSpanFull(),
                
                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Enter category description ')
                    ->rows(3)
                    ->maxLength(100),
                Toggle::make('status')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->default(true)
                    ->formatStateUsing(fn($state) => (bool) $state)
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0)
                    ->columnSpanFull(),
            ]);
    }
}
