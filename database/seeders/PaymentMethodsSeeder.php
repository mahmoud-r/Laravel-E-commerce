<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'stripe' => [
                'payment_stripe_name' => 'Pay online via Stripe (International and Domestic)',
                'payment_stripe_description' => 'You will be redirected to Stripe to complete the payment. (Debit card/Credit card/Online banking)',
                'payment_stripe_client_id' => 'your-stripe-public-key',
                'payment_stripe_secret' => 'your-stripe-private-key',
                'payment_stripe_webhook_secret' => 'your-stripe-webhook-secret',
                'status'=>'0'
            ],
            'paypal' => [
                'payment_paypal_name' => 'Fast and safe online payment via PayPal',
                'payment_paypal_description' => 'You will be redirected to PayPal to complete the payment.',
                'payment_paypal_client_id' => 'your-paypal-client-id',
                'payment_paypal_client_secret' => 'your-paypal-client-secret',
                'payment_paypal_mode' => 'sandbox',
                'status'=>'0'
            ],
            'cod' => [
                'payment_cod_name' => 'Cash on delivery (COD)',
                'payment_cod_description' => 'Please pay money directly to the postman, if you choose cash on delivery method (COD).',
                'status'=>'1',
                'payment_cod_minimum_amount' => '0',
                'payment_cod_maximum_amount' => '0',
            ],
            'bank_transfer' => [
                'payment_bank_transfer_name' => 'Bank transfer',
                'payment_bank_transfer_description' => 'Please send money to our bank account: ACB - 69270 213 19.',
                'payment_bank_transfer_display_bank_info' => '1',
                'status'=>'0'
            ]
        ];
        foreach ($settings as $method => $setting) {
            foreach ($setting as $key => $value) {
                PaymentMethod::create([
                    'payment_method' => $method,
                    'key' => $key,
                    'value' => $value
                ]);
            }
        }
    }
}
