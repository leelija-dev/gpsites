<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\UserMailHistory;
use Filament\Pages\Page;
use Livewire\Attributes\Url;

class ClientMailConversation extends Page
{
    protected string $view = 'filament.pages.client-mail-conversation';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Conversation';

    #[Url(as: 'thread')]
    public ?int $threadId = null;

    public function loadThread(): UserMailHistory
    {
        return UserMailHistory::findOrFail($this->threadId);
    }

    public function threadMessages(UserMailHistory $thread)
    {
        return $thread->messages()->orderBy('created_at')->get();
    }

    public function threadCustomer(UserMailHistory $thread): ?User
    {
        return User::find($thread->user_id);
    }
}