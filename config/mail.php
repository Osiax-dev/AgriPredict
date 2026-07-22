<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Laravel')),
    ],
    'logo_base64' => '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',

];
