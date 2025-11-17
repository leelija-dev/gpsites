<?php

namespace App\Filament\Resources\Users\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Pages\UserMail;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
               TextColumn::make('name')
                ->label('User Name')
                ->searchable()
                ->sortable(),
                TextColumn::make('email')->searchable()->sortable()
                 //->url(fn ($record) => url('admin/user-mail')) // optional route
                 ->url(fn ($record) => UserMail::getUrl(['email' => $record->email]))
                , // optional,
                TextColumn::make('created_at')->dateTime('M d,Y H:i a'),
                //ToggleColumn::make('status')
                ToggleColumn::make('status')
                ->afterStateUpdated(function ($record, $state) {
                    // Save updated status
                    $record->status = $state;
                    $record->save();

                    // Filament Alert Notification
                    \Filament\Notifications\Notification::make()
                        ->title($state ? 'User Activated' : 'User Deactivated')
                        ->body('Status updated successfully.')
                        ->success()
                        ->send();
                }),
                // ->beforeStateUpdated(function ($record, $state) {
                //     // Runs before the state is saved to the database.
                // })
                // ->afterStateUpdated(function ($record, $state) {
                //     // Runs after the state is saved to the database.
                // })
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
