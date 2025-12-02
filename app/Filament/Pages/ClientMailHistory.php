<?php

namespace App\Filament\Pages;
use App\Models\UserMailHistory;

use Filament\Pages\Page;

class ClientMailHistory extends Page
{
    protected string $view = 'filament.pages.client-mail-history';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar

     public function getLogs()
    {
        $userId = request('user_id'); // fetch user_id from URL

        return UserMailHistory::where('user_id', $userId)
            ->latest()
           ->get();
    }
}
