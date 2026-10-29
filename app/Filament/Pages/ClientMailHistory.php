<?php

namespace App\Filament\Pages;
use App\Models\UserMailHistory;

use Filament\Pages\Page;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
class ClientMailHistory extends Page
{
    use WithPagination;
    protected string $view = 'filament.pages.client-mail-history';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar

    #[Url(as: 'user_id')]
    public ?int $userId = null;   // stays available on every page change
    
    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'type', except: '')]
    public string $mailType = ''; 
        public function updatedSearch(): void   { $this->resetPage(); }
    public function updatedMailType(): void { $this->resetPage(); }

      public function clearFilters(): void
    {
        $this->reset(['search', 'mailType']);
        $this->resetPage();
    }

    public function getLogs()
    {
        $search = trim($this->search);

        return UserMailHistory::where('user_id', $this->userId)
            ->when(in_array($this->mailType, ['campaign', 'offer', 'order'], true),
                fn ($q) => $q->where('mail_type', $this->mailType))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('site_url', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('blog_email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);
    }
}
