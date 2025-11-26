<?php

namespace App\Filament\Resources\Orders\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
class OrdersTable
{
    public static function configure(Table $table): Table 
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('user_id')
                    ->label('User ID')
                    ->searchable(),
                // TextColumn::make('plan_id')
                //     ->label('Plan ID')
                //     ->searchable(),
                TextColumn::make('amount')
                    ->searchable(),
                // TextColumn::make('paid_at')
                //     ->searchable()
                //     ->dateTime(),

                TextColumn::make('transaction_id')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
