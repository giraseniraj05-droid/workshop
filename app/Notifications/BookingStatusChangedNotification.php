<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use Illuminate\Support\Facades\App;

class BookingStatusChangedNotification extends Notification
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
            $statusTranslated = __('messages.' . $this->booking->status, [], $locale);
            $message = (new MailMessage)
                ->subject(__('messages.email_status_changed_subject', ['status' => $statusTranslated], $locale))
                ->greeting(__('messages.email_greeting', ['name' => $this->booking->customer->name], $locale))
                ->line(__('messages.email_status_changed_line1', [], $locale));

            if ($this->booking->status === 'accepted') {
                $message->line(__('messages.email_status_changed_accepted', ['service' => $this->booking->service->name], $locale));
                if ($this->booking->worker) {
                    $message->line(__('messages.email_status_changed_assigned', ['worker' => $this->booking->worker->name], $locale));
                }
            } elseif ($this->booking->status === 'rejected') {
                $message->line(__('messages.email_status_changed_rejected', ['service' => $this->booking->service->name], $locale));
            } elseif ($this->booking->status === 'completed') {
                $message->line(__('messages.email_status_changed_completed', ['service' => $this->booking->service->name], $locale));
            } elseif ($this->booking->status === 'cancelled') {
                $message->line(__('messages.email_status_changed_cancelled', ['service' => $this->booking->service->name], $locale));
            } else {
                $message->line(__('messages.email_status_changed_generic', ['status' => $statusTranslated], $locale));
            }

            $slotKey = match($this->booking->preferred_time) {
                '09:00 AM - 11:00 AM' => 'slot_morning',
                '11:00 AM - 01:00 PM' => 'slot_late_morning',
                '02:00 PM - 04:00 PM' => 'slot_afternoon',
                '04:00 PM - 06:00 PM' => 'slot_evening',
                default => null
            };
            $slotText = $slotKey ? __('messages.' . $slotKey, [], $locale) : $this->booking->preferred_time;

            return $message
                ->line('**' . __('messages.email_status_details', [], $locale) . '**')
                ->line('- **' . __('messages.column_service', [], $locale) . ':** ' . $this->booking->service->name)
                ->line('- **' . __('messages.date_label', [], $locale) . ' ' . \Carbon\Carbon::parse($this->booking->booking_date)->translatedFormat('d F Y'))
                ->line('- **' . __('messages.slot_label', [], $locale) . ' ' . $slotText)
                ->action(__('messages.email_view_bookings', [], $locale), url('/dashboard'))
                ->line(__('messages.email_support', [], $locale));
        } finally {
            App::setLocale($currentLocale);
        }
    }
}
