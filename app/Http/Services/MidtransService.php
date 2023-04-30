<?php 

namespace App\Http\Services;
use GuzzleHttp\Client;

class MidtransService
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;
    public function __construct() {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout($params)
    {

        // Create transaction
        $transaction = array(
            'transaction_details' => $params['transaction_details'],
            // 'item_details' => $params['item_details'],
            'customer_details' => $params['customer_details']
        );

        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        return $snapToken;
    }
}

