<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLikeNotification extends Notification
{
    use Queueable;
    public User $user;
    public User $author;
    public Post $post;
    /**
     * Create a new notification instance.
     */
    public function __construct($user,$author, $post)
    {
        $this->author = $author;
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->user->name,
            'post_title' => $this->post->title,
            'post_id' => $this->post->id,
            'message' => 'liked',
        ];
    }
}
