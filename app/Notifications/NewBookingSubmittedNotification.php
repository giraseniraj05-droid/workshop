<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use Illuminate\Support\Facades\App;

class NewBookingSubmittedNotification extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $currentLocale = app()->getLocale();
        $locale = $notifiable->locale ?? $currentLocale;
        App::setLocale($locale);

        try {
            $slotKey = match($this->booking->preferred_time) {
                '09:00 AM - 11:00 AM' => 'slot_morning',
                '11:00 AM - 01:00 PM' => 'slot_late_morning',
                '02:00 PM - 04:00 PM' => 'slot_afternoon',
                '04:00 PM - 06:00 PM' => 'slot_evening',
                default => null
            };
            $slotText = $slotKey ? __('messages.' . $slotKey, [], $locale) : $this->booking->preferred_time;

            return (new MailMessage)
                ->subject(__('messages.email_new_booking_subject', [], $locale))
                ->greeting(__('messages.email_greeting', ['name' => $notifiable->name], $locale))
                ->line(__('messages.email_new_booking_line1', ['service' => $this->booking->service->name], $locale))
                ->line('**' . __('messages.email_status_details', [], $locale) . '**')
                ->line('- **' . __('messages.column_customer', [], $locale) . ' ' . $this->booking->customer->name)
                ->line('- **' . __('messages.column_service', [], $locale) . ' ' . $this->booking->service->name)
                ->line('- **' . __('messages.date_label', [], $locale) . ' ' . \Carbon\Carbon::parse($this->booking->booking_date)->translatedFormat('d F Y'))
                ->line('- **' . __('messages.slot_label', [], $locale) . ' ' . $slotText)
                ->line('- **' . __('messages.address_label', [], $locale) . ' ' . $this->booking->address)
                ->action(__('messages.email_new_enquiry_action', [], $locale), url('/admin/bookings/' . $this->booking->id))
                ->line(__('messages.email_new_booking_line2', [], $locale));
        } finally {
            App::setLocale($currentLocale);
        }
    }
}
