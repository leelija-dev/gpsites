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
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->url(fn ($record) => route('filament.admin.resources.users.edit', $record->user_id)),

                TextColumn::make('amount')
                    ->money('USD', true)
                    ->searchable(),

                TextColumn::make('plan.name')
                    ->label('Plan Name'),

                TextColumn::make('transaction_id')
                    ->searchable()
                    ->label("Transaction ID"),

                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => match (strtolower($state)) {
                        'completed' => 'Completed',
                        'pending' => 'Pending',
                        'failed' => 'Failed',
                        'incomplete' => 'Incomplete',
                        'processing' => 'Processing',
                        default => ucfirst($state ?? ''),
                    })
                    ->color(fn ($state) => match (strtolower($state)) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'incomplete' => 'danger',
                        'processing' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Order Date')
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
