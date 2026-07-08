<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Enquiry;
use Illuminate\Support\Facades\App;

class NewEnquirySubmittedNotification extends Notification
{
    use Queueable;

    protected $enquiry;

    /**
     * Create a new notification instance.
     */
    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
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
            return (new MailMessage)
                ->subject(__('messages.email_new_enquiry_subject', [], $locale))
                ->greeting(__('messages.email_greeting', ['name' => $notifiable->name], $locale))
                ->line(__('messages.email_new_enquiry_line1', ['service' => $this->enquiry->service->name ?? 'Service'], $locale))
                ->line('**' . __('messages.email_status_details', [], $locale) . '**')
                ->line('- **' . __('messages.column_customer', [], $locale) . ':** ' . $this->enquiry->customer_name)
                ->line('- **' . __('messages.email_label', [], $locale) . ':** ' . $this->enquiry->email)
                ->line('- **' . __('messages.phone_label', [], $locale) . ':** ' . $this->enquiry->phone)
                ->line('- **' . __('messages.column_service', [], $locale) . ':** ' . ($this->enquiry->service->name ?? 'Service'))
                ->line('- **' . __('messages.enquiry_msg', [], $locale) . ':** ' . $this->enquiry->message)
                ->action(__('messages.email_new_enquiry_action', [], $locale), url('/admin/enquiries/' . $this->enquiry->id))
                ->line(__('messages.email_support', [], $locale));
        } finally {
            App::setLocale($currentLocale);
        }
    }
}
