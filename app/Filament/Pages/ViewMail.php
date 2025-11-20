<?php

// namespace App\Filament\Pages;

// use Filament\Pages\Page;

// class ViewMail extends Page
// {
//     protected string $view = 'filament.pages.view-mail';
// }

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\MailHistories;

class ViewMail extends Page
{
    protected static ?string $slug = 'view-mail';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Mail Details';

    public $mail;

    public function mount()
    {
        $id = request()->query('id');
        $this->mail = MailHistories::findOrFail($id);
    }

    protected string $view = 'filament.pages.view-mail';
}
