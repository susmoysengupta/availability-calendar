<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var mixed
     */
    private $inviteUrl;
    /**
     * @var mixed
     */
    private $welcomeMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inviteUrl, $welcomeMessage)
    {
        $this->inviteUrl = $inviteUrl;
        $this->welcomeMessage = $welcomeMessage;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('An account has been created for you')
            ->markdown('emails.team-invite', [
                'inviteUrl' => $this->inviteUrl,
                'welcomeMessage' => $this->welcomeMessage,
            ]);

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
