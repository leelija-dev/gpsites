<?php

namespace App\Filament\Pages;
use App\Models\MailHistories;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
class UserMailHistory extends Page
{
    protected static ?int $navigationSort = 2;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected string $view = 'filament.pages.user-mail-history';
    public static function getNavigationGroup(): ?string
    {
        return 'User Management';
    }
    public function getLogs()
    {
        return MailHistories::where('sent_at','user mail')->get();
    }
}
