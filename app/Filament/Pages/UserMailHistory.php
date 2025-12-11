<?php

namespace App\Filament\Pages;
use App\Models\MailHistories;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class UserMailHistory extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?int $navigationSort = 6;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected string $view = 'filament.pages.user-mail-history';
    protected static ?string $title = 'User Mail History';

    public static function getNavigationLabel(): string
    {
        return 'Mail History';
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MailHistories::query()->where('sent_at', 'user mail')
            )
            ->columns([
                TextColumn::make('id')
                    ->label('SL No')
                    ->sortable()
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration;
                    }),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getState();
                    }),
                TextColumn::make('message')
                    ->label('Message')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => strip_tags($state))
                    ->limit(20)
                    ->tooltip(function (TextColumn $column): ?string {
                        return strip_tags($column->getState());
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state == 1 ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state == 1 ? 'Sent' : 'Failed'),
                TextColumn::make('created_at')
                    ->label('Sent at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record): string => url('admin/view-mail?id=' . $record->id))
                    ,
            ])
            ->emptyStateHeading('Not Available!')
            ->emptyStateDescription('User mail history not available.')
            ->emptyStateActions([
                // You can add actions here if needed
            ]);
    }
}
