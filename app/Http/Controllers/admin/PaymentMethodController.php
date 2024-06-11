<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    public function index()
    {
        $stripeSettings = PaymentMethod::getSettings('stripe');
        $paypalSettings = PaymentMethod::getSettings('paypal');
        $codSettings = PaymentMethod::getSettings('cod');
        $bankTransferSettings = PaymentMethod::getSettings('bank_transfer');

        return view('admin.payments.methods',compact('stripeSettings','codSettings','paypalSettings','bankTransferSettings'));
    }

    public function update(Request $request){

        if ($this->updatePaymentMethod($request) == true){
            return redirect()->back()->with('success', 'Payment method updated successfully.');
        }

    }


    public function updateStatus(Request $request)
    {

        if ($this->updatePaymentMethod($request) == true){
            session()->flash('success', 'Payment method Suatus updated successfully.');
            return response()->json([
                'status'=>true,
                'msg' =>'Payment method updated successfully.'
            ]);
        }

    }


    private function updatePaymentMethod(Request $request){
        $type = $request->input('type');

        $existingSettings = PaymentMethod::where('payment_method', $type)->pluck('key', 'value')->toArray();

        $fieldMappings = [
            'stripe' => [
                'payment_stripe_name' => 'payment_stripe_name',
                'payment_stripe_description' => 'payment_stripe_description',
                'payment_stripe_client_id' => 'payment_stripe_client_id',
                'payment_stripe_secret' => 'payment_stripe_secret',
                'payment_stripe_webhook_secret' => 'payment_stripe_webhook_secret',
                'status' => 'status'
            ],
            'paypal' => [
                'payment_paypal_name' => 'payment_paypal_name',
                'payment_paypal_description' => 'payment_paypal_description',
                'payment_paypal_client_id' => 'payment_paypal_client_id',
                'payment_paypal_client_secret' => 'payment_paypal_client_secret',
                'payment_paypal_mode' => 'payment_paypal_mode',
                'status' => 'status'
            ],
            'cod' => [
                'payment_cod_name' => 'payment_cod_name',
                'payment_cod_description' => 'payment_cod_description',
                'status' => 'status',
                'payment_cod_minimum_amount' => 'payment_cod_minimum_amount',
                'payment_cod_maximum_amount' => 'payment_cod_maximum_amount',
            ],
            'bank_transfer' => [
                'payment_bank_transfer_name' => 'payment_bank_transfer_name',
                'payment_bank_transfer_description' => 'payment_bank_transfer_description',
                'payment_bank_transfer_display_bank_info' => 'payment_bank_transfer_display_bank_info',
                'status' => 'status'
            ],
        ];

        $fields = $fieldMappings[$type] ?? [];

        foreach ($fields as $key => $field) {
            if ($request->has($field)) {
                PaymentMethod::updateOrCreate(
                    ['payment_method' => $type, 'key' => $key],
                    ['value' => $request->input($field)]
                );
            }
        }
        return [
          'status'=>true
        ];
    }
}
