<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    protected string $view = 'filament.pages.view-order';
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            ViewAction::make(),
        ];
    }
}

//     public function form(Schema $schema): Schema
//     {
//         return $schema
//             ->schema([
//                 Section::make('Order Details')
//                     ->schema([
//                         TextEntry::make('id')
//     ->label('Order ID')
//     ->extraAttributes([
//         'class' => 'rounded-lg border border-danger px-3 py-2 bg-gray-50'
//     ])
//     ->disabled(),


//                         // TextEntry::make('plan_id')
//                         //     ->label('Plan Name')
//                         //     ,
                            
//                     TextEntry::make('plan.name')
//                         ->label('Plan Name')
//                         ->placeholder('N/A'),

//                         TextEntry::make('amount')
//                             ->label('Amount')
//                             ->formatStateUsing(fn ($state) => '$' . number_format($state, 2)),

//                         TextEntry::make('status')
//                             ->label('Status'),

//                         TextEntry::make('transaction_id')
//                             ->label('Transaction ID'),

//                         TextEntry::make('created_at')
//                             ->label('Order Date')
//                            ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d-m-Y, h:i A'))
//                            ->disabled(),
                           
//                     ]),
//             ]);
//     }
// }
