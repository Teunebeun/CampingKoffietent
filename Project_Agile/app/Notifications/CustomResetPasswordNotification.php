<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use function Composer\Autoload\includeFile;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * @throws \Throwable
     */
    public function toMail($notifiable)
    {
        $converter = new CssToInlineStyles();
        error_log(public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'CampingKoffietentImage.png');
        $html = view('auth.email', ['user' => $notifiable, 'path_to_logo' => 'https://i.imgur.com/8V2nFvD.jpg', 'token' => $this->token])->render(); // Foto van de camping kan pas via een derde partij (mail) geopend worden op het moment dat de website gedeployed is.
        $css = file_get_contents(public_path().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'CMS'.DIRECTORY_SEPARATOR.'login.css');

        $stylizedEmail = view('auth.inline_style_email')->getPath();
        file_put_contents($stylizedEmail, $converter->convert($html, $css));

        $message = new MailMessage();
        error_log($this->token ?? 'HIJ DOET HET NIET!');
        return $message
            ->view('auth.inline_style_email')
            ->subject('Camping Koffietent - Wachtwoord Herstel');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
