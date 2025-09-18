<?php

namespace App\Notifications;

use App\Models\TinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TinRequestRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tinRequest;
    public $rejectionReason;

    /**
     * Create a new notification instance.
     */
    public function __construct(TinRequest $tinRequest, string $rejectionReason)
    {
        $this->tinRequest = $tinRequest;
        $this->rejectionReason = $rejectionReason;
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
        $url = url('/tin-requests/create');
        
        return (new MailMessage)
            ->subject('Your TIN Request Has Been Rejected')
            ->line('We regret to inform you that your TIN request has been rejected.')
            ->line('Reason for rejection: ' . $this->rejectionReason)
            ->action('Submit New Request', $url)
            ->line('You may submit a new request with corrected information.')
            ->line('If you have any questions, please contact our support team.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tin_request_id' => $this->tinRequest->id,
            'message' => 'Your TIN request has been rejected. Reason: ' . $this->rejectionReason,
            'url' => '/tin-requests/create',
        ];
    }
}
