<?php

namespace App\Filament\Pages;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Pages\Page;
use App\Models\User;
use App\Models\PlanOrder;
use App\Models\MailHistories;
use App\Models\MailAvailable;
use App\Models\Plan;
use App\Models\Contact;
use App\Models\UserMailHistory;

// use Filament\Pages\Dashboard as BaseDashboard;
class Dashboard extends Page //BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;
       
    public function mount()
    {
        // Send total customer count to Blade
        $this->totalCustomers = User::count();
        $this->totalOrders= PlanOrder::where('status', 'completed')->with('plan')->get();//where('status', 'completed')->count();

        $this->totalMailSent = UserMailHistory::count();
        $this->totalMail = MailAvailable::all();
        $this->latestContact = Contact::all();
        $this->plans= Plan::all();
    }
    public function searchByDate()
    {
        $query = Contact::query();

        if ($this->from_date) {
            $query->whereDate('created_at', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->whereDate('created_at', '<=', $this->to_date);
        }

        $this->latestContact = $query->orderBy('created_at', 'desc')->get();
    }
}
