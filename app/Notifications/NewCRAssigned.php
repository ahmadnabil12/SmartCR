<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ChangeRequest;

class NewCRAssigned extends Notification
{
    protected $cr;

    public function __construct(ChangeRequest $cr)
    {
        $this->cr = $cr;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have a new Change Request')
            ->greeting('Hi ' . $notifiable->name)
            ->line('You have been assigned a new Change Request:')
            ->line('Title: ' . $this->cr->title)
            ->line('Due: ' . $this->cr->need_by_date)
            ->action('View CR', url('/change-requests/' . $this->cr->id))
            ->line('Please attend to it as soon as possible.');
    }
}

