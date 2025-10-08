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
                ->subject(__('Verificatie Account'))
                ->greeting(__('Hallo, ' . $notifiable->name))
                ->line(__('U heeft een verificatie-e-mail aangevraagd. Klik op de knop hieronder om uw e-mailadres te verifiëren.'))
                ->action(__('Verifieer E-mailadres'), $verificationUrl)
                ->salutation(__('Met vriendelijke groet,') . "\n" . config('app.name'))
                ->line(__('Als de knop niet werkt, kopieer en plak de volgende link in uw browser:') . "\n" . $verificationUrl);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject(__('Wachtwoord Vergeten'))
                ->greeting(__('Hallo, ' . $notifiable->name))
                ->line(__('U heeft aangegeven dat u uw wachtwoord bent vergeten. Klik op de knop hieronder om uw wachtwoord opnieuw in te stellen.'))
                ->action(__('Opnieuw Instellen'), $url)
                ->salutation(__('Met vriendelijke groet,') . "\n" . config('app.name'))
                ->line(__('Als de knop niet werkt, kopieer en plak de volgende link in uw browser:') . "\n" . $url);
        });
    }
}
