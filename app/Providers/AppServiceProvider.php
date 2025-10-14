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

        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject(__('mail.verify.subject'))
                ->greeting(__('mail.verify.greeting', ['name' => $notifiable->name]))
                ->line(__('mail.verify.line'))
                ->action(__('mail.verify.action'), $verificationUrl)
                ->salutation(__('mail.verify.salutation', ['app' => config('app.name')]));
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject(__('mail.reset.subject'))
                ->greeting(__('mail.reset.greeting', ['name' => $notifiable->name]))
                ->line(__('mail.reset.line'))
                ->action(__('mail.reset.action'), $url)
                ->salutation(__('mail.reset.salutation', ['app' => config('app.name')]));
        });
    }
}
