<?php

namespace App\Filament\Resources\PlanFeatures\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use App\Models\Plan;

class PlanFeaturesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
             // Select Plan dropdown
                Select::make('plan_id')
                    ->label('Select Plan')
                    ->options(Plan::pluck('name', 'id')) // id → value, name → label
                    ->searchable()
                    ->required(),

                // Other form inputs
                TextInput::make('feature')
                    ->label('Feature')
                    ->required(),

                 Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
