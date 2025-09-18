<?php

namespace App\Notifications;

use App\Models\TinRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TinRequestApprovedNotification extends Notification implements ShouldQueue
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
        $url = url('/tin-requests/' . $this->tinRequest->id . '/download');
        
        return (new MailMessage)
            ->subject('Your TIN Request Has Been Approved')
            ->line('Congratulations! Your TIN request has been approved.')
            ->line('Your TIN Number: ' . $this->tinRequest->tin_number)
            ->action('Download TIN Certificate', $url)
            ->line('You can now use this TIN for all your tax-related activities.')
            ->line('Thank you for using our services!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tin_request_id' => $this->tinRequest->id,
            'tin_number' => $this->tinRequest->tin_number,
            'message' => 'Your TIN request has been approved. TIN: ' . $this->tinRequest->tin_number,
            'url' => '/tin-requests/' . $this->tinRequest->id,
        ];
    }
}
