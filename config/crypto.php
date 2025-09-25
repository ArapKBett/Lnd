<?php
return [
    'api_key' => env('COINREMITTER_API_KEY'),
    'coins' => ['BTC', 'USDT'],
    'webhook_url' => env('APP_URL') . '/crypto/webhook',
];
