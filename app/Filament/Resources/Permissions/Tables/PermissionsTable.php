<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->label('Permission'),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ]);
    }
}
