<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
class UpdateProfile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected string $view = 'filament.pages.update-profile';
    protected static ?string $title = 'Profile';
}


    