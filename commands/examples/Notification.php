<?php

namespace App\Notifications;

class NotificationName extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return [];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function array(): array
    {

    }

    /**
     * Get the mail representation of the notification.
     *
     * @return void
     */
    public function email(): void
    {

    }
}
