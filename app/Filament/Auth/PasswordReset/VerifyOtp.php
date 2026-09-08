<?php

namespace App\Filament\Auth\PasswordReset;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/**
 * @property Form $form
 */
class VerifyOtp extends SimplePage
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    protected static string $view = 'filament.pages.auth.password-reset.verify-otp';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public static function routes(Panel $panel): void
    {
        // Livewire can only reverse-resolve a component's auto-derived name
        // back to its class when the class lives under the configured
        // `livewire.class_namespace` (default App\Livewire). This page lives
        // alongside the other Filament auth pages instead, so without an
        // explicit alias, Livewire's update requests fail to find the class
        // and throw (surfacing to the browser as a bogus 419).
        Livewire::component('verify-otp', static::class);

        Route::get('/verify-otp', static::class)
            ->name('verify-otp');
    }

    public static function getUrl(array $parameters = []): string
    {
        return Filament::getCurrentPanel()->route('verify-otp', $parameters);
    }

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            $this->redirect(Filament::getUrl());

            return;
        }

        $email = (string) request()->query('email', '');

        if (blank($email)) {
            $this->redirect(Filament::getRequestPasswordResetUrl());

            return;
        }

        $this->form->fill([
            'email' => $email,
            'otp' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Hidden::make('email'),
                        TextInput::make('otp')
                            ->label('Verification code')
                            ->helperText('Enter the 6-digit code we emailed you.')
                            ->required()
                            ->numeric()
                            ->minLength(6)
                            ->maxLength(6)
                            ->autofocus()
                            ->autocomplete('one-time-code'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function verify(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title('Too many attempts. Please wait before trying again.')
                ->danger()
                ->send();

            return;
        }

        $data = $this->form->getState();
        $email = $data['email'];
        $otp = (string) $data['otp'];

        $record = DB::table('password_reset_otps')->where('email', $email)->first();

        $invalid = (! $record)
            || now()->greaterThan($record->expires_at)
            || ($record->attempts >= 5)
            || (! Hash::check($otp, $record->otp));

        if ($invalid) {
            if ($record) {
                DB::table('password_reset_otps')->where('email', $email)->increment('attempts');
            }

            Notification::make()
                ->title('That code is invalid or has expired.')
                ->danger()
                ->send();

            return;
        }

        DB::table('password_reset_otps')->where('email', $email)->delete();

        $user = User::where('email', $email)->first();

        if (! $user) {
            Notification::make()
                ->title('Something went wrong. Please request a new code.')
                ->danger()
                ->send();

            $this->redirect(Filament::getRequestPasswordResetUrl());

            return;
        }

        $token = Password::broker(Filament::getAuthPasswordBroker())->createToken($user);

        $this->redirect(Filament::getResetPasswordUrl($token, $user));
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('verify')
                ->label('Verify code')
                ->submit('verify'),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    public function getTitle(): string | Htmlable
    {
        return 'Verify code';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Enter verification code';
    }
}
