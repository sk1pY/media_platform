<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriberNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */


    public User $subscriber;
    public User $subscribedTo;
    public function __construct(User $subscriber,User $subscribedTo)
    {
        $this->subscriber = $subscriber;
        $this->subscribedTo = $subscribedTo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line($this->subscriber->name.' following to you')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'subscriber_id' => $this->subscriber->id,
            'subscriber_name' => $this->subscriber->name,
            'message' => 'Your apartment was created successfully.',
        ];
    }
}
