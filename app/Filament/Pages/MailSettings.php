<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailSettings extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Email (SMTP)';

    protected static ?string $title = 'Email (SMTP) Settings';

    protected static string $view = 'filament.pages.mail-settings';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'mail_host' => Setting::get('mail_host', 'smtp.gmail.com'),
            'mail_port' => Setting::get('mail_port', '587'),
            'mail_encryption' => Setting::get('mail_encryption', 'tls'),
            'mail_username' => Setting::get('mail_username'),
            'mail_password' => null,
            'mail_from_address' => Setting::get('mail_from_address'),
            'mail_from_name' => Setting::get('mail_from_name', config('app.name')),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Gmail SMTP')
                    ->description('Used to send admin password-reset codes and other system emails via a Gmail account. In Google Account → Security, enable 2-Step Verification, then generate an "App password" to use below (a normal Gmail password will not work).')
                    ->columns(2)
                    ->schema([
                        TextInput::make('mail_host')
                            ->label('SMTP host')
                            ->default('smtp.gmail.com')
                            ->required(),
                        TextInput::make('mail_port')
                            ->label('SMTP port')
                            ->numeric()
                            ->default(587)
                            ->required(),
                        Select::make('mail_encryption')
                            ->label('Encryption')
                            ->options([
                                'tls' => 'TLS (port 587)',
                                'ssl' => 'SSL (port 465)',
                            ])
                            ->default('tls')
                            ->required(),
                        TextInput::make('mail_username')
                            ->label('Gmail address')
                            ->email()
                            ->required(),
                        TextInput::make('mail_password')
                            ->label('Gmail app password')
                            ->password()
                            ->revealable()
                            ->helperText('Leave blank to keep the currently saved password.')
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                        TextInput::make('mail_from_address')
                            ->label('"From" address')
                            ->email()
                            ->required(),
                        TextInput::make('mail_from_name')
                            ->label('"From" name')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::updateOrCreate(['key' => 'mail_host'], ['value' => $data['mail_host']]);
        Setting::updateOrCreate(['key' => 'mail_port'], ['value' => $data['mail_port']]);
        Setting::updateOrCreate(['key' => 'mail_encryption'], ['value' => $data['mail_encryption']]);
        Setting::updateOrCreate(['key' => 'mail_username'], ['value' => $data['mail_username']]);
        Setting::updateOrCreate(['key' => 'mail_from_address'], ['value' => $data['mail_from_address']]);
        Setting::updateOrCreate(['key' => 'mail_from_name'], ['value' => $data['mail_from_name']]);

        if (filled($data['mail_password'] ?? null)) {
            Setting::updateOrCreate(
                ['key' => 'mail_password'],
                ['value' => Crypt::encryptString($data['mail_password'])],
            );
        }

        Notification::make()
            ->title('SMTP settings saved')
            ->success()
            ->send();

        $this->form->fill([...$this->form->getState(), 'mail_password' => null]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save'),
            Action::make('sendTest')
                ->label('Send test email')
                ->color('gray')
                ->action(fn () => $this->sendTestEmail()),
        ];
    }

    public function sendTestEmail(): void
    {
        $this->save();

        $recipient = Filament::auth()->user()?->email;

        if (blank($recipient)) {
            return;
        }

        try {
            Mail::raw(
                'This is a test email from RJS Pharma Admin to confirm your SMTP settings are working.',
                fn ($message) => $message->to($recipient)->subject('RJS Pharma Admin — Test email'),
            );

            Notification::make()
                ->title("Test email sent to {$recipient}")
                ->success()
                ->send();
        } catch (Throwable $exception) {
            Notification::make()
                ->title('Could not send test email')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }
}
