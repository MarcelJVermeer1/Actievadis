<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {
        Schema::defaultStringLength(191);

        // just need to change the placeholders..
        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject(__('mail.verify_subject'))
                ->line(__('mail.verify_line'))
                ->action(__('mail.verify_action'), $verificationUrl)
                ->line(__('mail.verify_no_action'));
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject(__('mail.reset_subject'))
                ->line(__('mail.reset_line'))
                ->action(__('mail.reset_action'), $url)
                ->line(__('mail.reset_expires', [
                    'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
                ]))
                ->line(__('mail.reset_no_action'));
        });
    }
}
