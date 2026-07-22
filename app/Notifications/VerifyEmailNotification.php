<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('🌾 Activez votre compte AgriPredict AI')
            ->from(config('mail.from.address'), 'AgriPredict AI') 
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Merci de rejoindre **AgriPredict AI**, la plateforme de prévision de rendement agricole par intelligence artificielle pour le Bénin.')
            ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email et activer votre compte.')
            ->action('✅ Activer mon compte', $verificationUrl)
            ->line('Si vous avez du mal à cliquer sur le bouton, copiez et collez le lien suivant dans votre navigateur :')
            ->line('Ce lien expirera dans **20minutes**.')
            ->line('Si vous n\'avez pas créé de compte sur AgriPredict AI, ignorez simplement cet email.')
            ->salutation('— L\'équipe AgriPredict AI 🌱');
    }

    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}