<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TempatinNotification extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    public ?string $actionUrl;
    public string $icon;
    public string $category;

    public function __construct(
        string $title,
        string $message,
        ?string $actionUrl = null,
        string $category = 'system',
        string $icon = 'fa-bell'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->category = $category;
        $this->icon = $icon;
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
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'category' => $this->category,
            'icon' => $this->icon,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
