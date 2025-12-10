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
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\Log;
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

          ToggleColumn::make('email_verified_at')
            ->label('Verified')
            ->updateStateUsing(function ($record, $state) {
                // Override the state before saving: true → now(), false → null
                return $state ? now() : null;
            })
            ->afterStateUpdated(function ($record, $state) {
               
            if($state){
                        $record->email_verified_at=now();
                    }else{
                        $record->email_verified_at = null;
                }
                    $record->save();
                    // Filament Alert Notification
                    \Filament\Notifications\Notification::make()
                        ->title($state ? 'Verified on' : 'Verified off')
                        ->body('Verified updated successfully.')
                        ->success()
                        ->send();
            }),
            ])
            ->filters([
                //
            ])
            // ->recordActions([
            //     EditAction::make(),

            // ])
            ->recordActions([
            \Filament\Actions\Action::make('view_orders')
                ->label('Orders')
                ->icon('heroicon-o-shopping-bag')
                ->color('info')
                ->url(fn ($record) => route('filament.admin.resources.orders.index', [
                 'user_id' => $record->id,
            ])),
            EditAction::make(),
            ViewAction::make('view_mail_history')
                ->label('History')
                ->icon('heroicon-o-inbox-stack')
                ->url(fn ($record) => route('filament.admin.pages.client-mail-history', ['user_id' => $record->id]))
                ->openUrlInNewTab(false),
        ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
