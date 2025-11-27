<?php

namespace App\Filament\Resources\Orders\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
class OrdersTable
{
    public static function configure(Table $table): Table 
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->label('Order Id')->searchable()->sortable(),
                TextColumn::make('user.name')
                    ->label('User Name')
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
                // EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
