<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Offer $offer
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $amount_fomratted = number_format((float)$this->offer->amount);
        return (new MailMessage)
            ->line("New offer ({$amount_fomratted} €) was made for your listing")
            ->action(
                'See the offer!',
                route('realtor.listing.show', ['listing' => $this->offer->listing_id])
            )
            ->line('Thank you for using HotPlaces!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'offer_id' => $this->offer->id,
            'listing_id' => $this->offer->listing_id,
            'amount' => $this->offer->amount,
            'user_id' => $this->offer->user_id
        ];
    }
}
