<?php

namespace App\Notifications;

use App\Models\TinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTinRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tinRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(TinRequest $tinRequest)
    {
        $this->tinRequest = $tinRequest;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/admin/tin-requests/' . $this->tinRequest->id);
        
        return (new MailMessage)
            ->subject('New TIN Request Received')
            ->line('A new TIN request has been submitted.')
            ->line('Applicant: ' . $this->tinRequest->full_name)
            ->line('NID: ' . $this->tinRequest->nid_number)
            ->action('Review Request', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tin_request_id' => $this->tinRequest->id,
            'message' => 'New TIN request from ' . $this->tinRequest->full_name,
            'url' => '/admin/tin-requests/' . $this->tinRequest->id,
        ];
    }
}
