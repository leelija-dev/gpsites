<?php

namespace App\Filament\Pages;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Page;
use BackedEnum;
use App\Models\MailHistories;

class MailHistory extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;
    protected string $view = 'filament.pages.mail-history';
    protected static ?string $title = 'Promotion Mail History';
    public static function getNavigationGroup(): ?string
    {
        return 'Promotion';
    }

    public static function getNavigationSort(): int
    {
        return 9;  // Position of the group in the sidebar
    }
    public function getLogs()
    {
        return MailHistories::where('sent_at','promotional mail')->get();
    }
}
