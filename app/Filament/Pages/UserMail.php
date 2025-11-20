<?php
namespace App\Filament\Pages;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\MailHistories;

class UserMail extends Page implements HasForms
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.user-mail';
    protected static ?string $slug= 'user-mail';
    protected static bool $shouldRegisterNavigation = false; 

    public ?string $email = null;
    public $message = null;
    public ?string $subject = null;


    // public ?string $email = null;

    public $data = [];

   public function mount(): void
{
    $this->email = request()->query('email');

    $this->form->fill([
        'email' => $this->email,
    
    ]);
    
}


    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(fn () => new HtmlString('Email Address<sup style="color:red">*</sup>'))
                ->email()
                ->placeholder('Enter email address'),
            TextInput::make('subject')
                ->label(fn () => new HtmlString('Subject<sup style="color:red">*</sup>'))
                ->placeholder('Enter email subject')
                ->rules(['required'])
                ->validationMessages([
                    'required' => 'Please enter email subject',
                ]),             

            RichEditor::make('message')
                ->label(fn () => new HtmlString('Message<sup style="color:red">*</sup>'))
                ->placeholder('Enter your message here...')
                ->rules(['required'])
                ->validationMessages([
                    'required' => 'Please enter the message',
                ]),

        ];
    


    }
     public function sendEmail()
{
    $data = $this->form->getState();

    if (empty($data['email'])) {
        Notification::make()->title('Email is required')->danger()->send();
        return;
    }

    if (empty($data['subject'])) {
        Notification::make()->title('Subject can not be blank!')->danger()->send();
        return;
    }

    if (empty($data['message'])) {
        Notification::make()->title('Message can not be blank!')->danger()->send();
        return;
    }

    Mail::html($data['message'], function ($mail) use ($data) {
        $mail->to($data['email'])->subject($data['subject']);
    });
    
    MailHistories::create([
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => 1, //sent 
                'sent_at' => 'user mail',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

    Notification::make()
        ->title('Promotion Email Sent Successfully!')
        ->success()
        ->send();

    $this->form->fill([
        'email' => $this->email,
        'subject' => '',
        'message' => '',
    ]);
}

}
