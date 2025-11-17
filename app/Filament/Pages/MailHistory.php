<?php

namespace App\Filament\Pages;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Page;
use BackedEnum;
use App\Models\MailHistories;

class MailHistory extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;
    
    protected string $view = 'filament.pages.mail-history';
    protected static ?string $title = 'Promotion Mail History';
    // protected static ?int $navigationSort = 99;
    protected static ?int $navigationSort = 99;
    public static function getNavigationGroup(): ?string
    {
        return 'Promotion';
    }
    public function getLogs()
    {
        return MailHistories::where('sent_at','promotional mail')->get();
    }





}
