<?php

declare(strict_types=1);

namespace OneRedPaperclip\Mail;

use Waaseyaa\Mail\Envelope;
use Waaseyaa\Mail\Transport\TransportInterface;

final class SendGridTransport implements TransportInterface
{
    private const string API_URL = 'https://api.sendgrid.com/v3/mail/send';

    public function __construct(
        private readonly string $apiKey,
    ) {}

    public function send(Envelope $envelope): void
    {
        $payload = [
            'personalizations' => [
                [
                    'to' => array_map(
                        fn (string $email) => ['email' => $email],
                        $envelope->to,
                    ),
                    'subject' => $envelope->subject,
                ],
            ],
            'from' => ['email' => $envelope->from],
            'content' => [],
        ];

        if ($envelope->textBody !== '') {
            $payload['content'][] = [
                'type' => 'text/plain',
                'value' => $envelope->textBody,
            ];
        }

        if ($envelope->htmlBody !== '') {
            $payload['content'][] = [
                'type' => 'text/html',
                'value' => $envelope->htmlBody,
            ];
        }

        if ($payload['content'] === []) {
            $payload['content'][] = [
                'type' => 'text/plain',
                'value' => ' ',
            ];
        }

        $ch = curl_init(self::API_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \RuntimeException("SendGrid API error (HTTP {$httpCode}): {$response}");
        }
    }
}
