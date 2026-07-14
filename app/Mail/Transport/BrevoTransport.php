<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoTransport extends AbstractTransport
{
    /**
     * The Brevo API Key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new Brevo transport instance.
     *
     * @param  string  $key
     * @return void
     */
    public function __construct(string $key)
    {
        parent::__construct();
        $this->key = $key;
    }

    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        // Extract sender
        $from = $email->getFrom();
        $sender = count($from) > 0 ? [
            'email' => $from[0]->getAddress(),
            'name' => $from[0]->getName() ?: config('mail.from.name'),
        ] : [
            'email' => config('mail.from.address'),
            'name' => config('mail.from.name'),
        ];

        // Extract recipients
        $to = [];
        foreach ($email->getTo() as $recipient) {
            $to[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }

        // Extract Cc
        $cc = [];
        foreach ($email->getCc() as $recipient) {
            $cc[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }

        // Extract Bcc
        $bcc = [];
        foreach ($email->getBcc() as $recipient) {
            $bcc[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: null,
            ];
        }

        // Extract subject
        $subject = $email->getSubject();

        // Extract content
        $html = $email->getHtmlBody();
        $text = $email->getTextBody();

        // Extract attachments
        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $headers = $attachment->getPreparedHeaders();
            $filename = 'attachment';
            if ($headers->has('Content-Disposition')) {
                $filename = $headers->getHeaderParameter('Content-Disposition', 'filename') ?: 'attachment';
            }
            $attachments[] = [
                'content' => base64_encode($attachment->getBody()),
                'name' => $filename,
            ];
        }

        // Build Brevo API payload
        $payload = [
            'sender' => $sender,
            'to' => $to,
            'subject' => $subject,
        ];

        if ($html) {
            $payload['htmlContent'] = $html;
        }

        if ($text) {
            $payload['textContent'] = $text;
        }

        if (!empty($cc)) {
            $payload['cc'] = $cc;
        }

        if (!empty($bcc)) {
            $payload['bcc'] = $bcc;
        }

        if (!empty($attachments)) {
            $payload['attachments'] = $attachments;
        }

        try {
            $response = Http::withHeaders([
                'api-key' => $this->key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', $payload);

            if ($response->failed()) {
                Log::error('[BREVO API ERROR] Failed to send email via Brevo REST API.', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'payload' => array_merge($payload, ['htmlContent' => '...HTML Content...']),
                ]);
            } else {
                Log::info('[BREVO API SUCCESS] Email sent successfully via Brevo REST API.', [
                    'messageId' => $response->json('messageId'),
                    'to' => array_column($to, 'email'),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('[BREVO API EXCEPTION] Exception occurred during Brevo API mail send: ' . $e->getMessage(), [
                'exception' => $e,
                'to' => array_column($to, 'email'),
            ]);
        }
    }

    /**
     * Get the string representation of the transport.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'brevo';
    }
}
