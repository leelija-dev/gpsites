<?php

namespace App\Filament\Resources\Plans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
           ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('name')
                    ->label('Plan Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')->searchable()->sortable()
                 ->money('USD', true),
                TextColumn::make('duration')
                    ->label('Duration(days)'),
                  TextColumn::make('mail_available')
                    ->label('Mail limit'),
                ToggleColumn::make('is_active')
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
