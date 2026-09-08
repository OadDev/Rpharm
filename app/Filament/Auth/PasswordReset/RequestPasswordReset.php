<?php

namespace App\Filament\Auth\PasswordReset;

use App\Models\User;
use App\Notifications\AdminPasswordResetOtp;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    public const OTP_VALID_MINUTES = 10;

    public function request(): void
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return;
        }

        $email = $this->form->getState()['email'];

        $user = User::where('email', $email)->first();

        if ($user) {
            $otp = (string) random_int(100000, 999999);

            DB::table('password_reset_otps')->updateOrInsert(
                ['email' => $email],
                [
                    'otp' => Hash::make($otp),
                    'attempts' => 0,
                    'expires_at' => now()->addMinutes(static::OTP_VALID_MINUTES),
                    'created_at' => now(),
                ],
            );

            $user->notify(new AdminPasswordResetOtp($otp, static::OTP_VALID_MINUTES));
        }

        Notification::make()
            ->title('If that email is registered, a verification code has been sent.')
            ->success()
            ->send();

        $this->redirect(VerifyOtp::getUrl(['email' => Str::of($email)->toString()]));
    }
}
