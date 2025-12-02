<?php

namespace App\Filament\Pages;

use App\Models\MailHistories;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\HtmlString;


use BackedEnum;

class Promotion extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    
    protected string $view = 'filament.pages.promotion';
    protected static ?string $title = 'Promotion';
    // protected static ?int $navigationSort = 98;
    protected  static ?string $slug = 'mail'; 

    public ?string $send_to = null;
    public ?string $email = null;
    public ?array $message = null;
    public ?string $subject = null;
    public static function getNavigationGroup(): ?string
    {
        return 'Promotion';
    }
    public static function getNavigationSort(): int
    {
        return 8;  // Position of the group in the sidebar
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('send_to')
                ->label(fn () => new HtmlString('Send To<sup style="color:red">*</sup>'))
                ->options([
                    'all_users' => 'All Users',
                    'custom_mail' => 'Custom Email',
                ])
                
                ->rules(['required'])
                ->validationMessages([
                    'required' => 'Please select sender mail',
                ])
                ->reactive(),

            TextInput::make('email')
                ->label(fn () => new HtmlString('Email Address<sup style="color:red">*</sup>'))
                ->email()
                ->placeholder('Enter email address')
                ->visible(fn (callable $get) => $get('send_to') === 'custom_mail')
                ->rules(['nullable', 'email'])
                ->validationMessages([
                    'email' => 'Please enter a valid email address.',
                ]),
            TextInput::make('subject')
                ->label(fn () => new HtmlString('Email Subject<sup style="color:red">*</sup>'))
                ->placeholder('Enter email subject')
                ->rules(['required'])
                ->validationMessages([
                    'required' => 'Email Subject can not be blank!',
                ]),


            RichEditor::make('message')
                ->label(fn () => new HtmlString('Promotion Message<sup style="color:red">*</sup>'))
                ->placeholder('Enter message here...')
                ->rules(['required'])
                // ->extraAttributes([
                //     'style'=>'height:300px;'
                // ])
                ->validationMessages([
                    'required' => 'Promotion Message can not be blank!',
                ]),
        ];
    }

    public function sendPromotion()
    {
        $data = $this->form->getState();

        if (!$data['send_to']) {
            Notification::make()->title('Send To is required')->danger()->send();
            return;
        }
        if(!$data['subject']){
            Notification::make()->title('Email Subject can not be blank')->danger()->send();
            return;
        }

        if (!$data['message']) {
            Notification::make()->title('Promotion Message is required')->danger()->send();
            return;
        }

        // Get emails based on selection
        if ($data['send_to'] === 'all_users') {
            $emails = User::pluck('email');
        } elseif ($data['send_to'] === 'premium_users') {
            //$emails = User::where('is_premium', true)->pluck('email');
        } elseif ($data['send_to'] === 'custom_mail') {
            if (empty($data['email'])) {
                Notification::make()->title('Email is required for Custom')->danger()->send();
                return;
            }
            $emails = collect([$data['email']]);
        }

        // Send emails
        foreach ($emails as $email) {
            Mail::html($data['message'], function ($mail) use ($email,$data) {
                $mail->to($email)->subject($data['subject']);
            });
              // Store success history
              
            MailHistories::create([
                'email' => $email,
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => 1, //sent 
                'sent_at' => 'promotional mail',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Notification::make()
            ->title('Promotion Email Sent Successfully!')
            ->success()
            ->send();

        // Reset form
        $this->reset(['send_to', 'email', 'message']);
    }
}
