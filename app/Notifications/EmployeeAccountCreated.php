<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeAccountCreated extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Création de votre compte employé - Vite & Gourmand')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre compte employé Vite & Gourmand a été créé par l’administrateur.')
            ->line('Votre adresse e-mail de connexion est : ' . $notifiable->email)
            ->line('Pour obtenir votre mot de passe provisoire, veuillez contacter l’administrateur.')
            ->line('Pour votre sécurité, aucun mot de passe n’est envoyé par e-mail.')
            ->line('Cordialement,')
            ->line('L’équipe Vite & Gourmand');
    }
}
