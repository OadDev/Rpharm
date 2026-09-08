<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPasswordResetOtp extends Notification
{
    use Queueable;

    public function __construct(
        protected string $otp,
        protected int $validMinutes,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your admin password reset code')
            ->greeting('Reset your password')
            ->line('Use the verification code below to reset your admin password.')
            ->line(new \Illuminate\Support\HtmlString(
                '<div style="font-size:32px;font-weight:700;letter-spacing:8px;text-align:center;margin:24px 0;">' . e($this->otp) . '</div>'
            ))
            ->line("This code expires in {$this->validMinutes} minutes.")
            ->line('If you did not request a password reset, no further action is required.');
    }
}
