<?php

return [
  'merchant_key' => env('MIDTRANS_MERCHANT_KEY'),
  'server_key' => env('MIDTRANS_SERVER_KEY'),
  'client_key' => env('MIDTRANS_CLIENT_KEY'),
  'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
];
