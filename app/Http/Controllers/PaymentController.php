<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\PaymentGateway\AirtelMoney;
use App\Http\PaymentGateway\VodacomMpesa;


class PaymentController extends Controller
{
    
    /**
     *  AIRTEL MONEY
     * 
     *  Get payment USSDPush request and process it.
     *  
     */
    public function getPayment(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:255'],
            'msisdn' => ['required'],
            'amount' => ['required'],
        ]);

        $data = [
            'reference' => $validated['reference'],
            'msisdn' => $validated['msisdn'],
            'amount' => $validated['amount']
        ];

        // Make request to get ussd push notification
        $response = (new AirtelMoney)->authenticate()->USSDPush($data);

        return $response;

    }


     /**
     *  Vodacom MPESA
     * 
     *  Get payment USSDPush request and process it.
     *  
     */
    public function getUSSDPush(Request $request)
    {

        $validated = $request->validate([
            'msisdn' => ['required'],
            'amount' => ['required'],
            'serviceProviderCode' => ['required'],
            'transaction_ID' => ['required'],
            'reference' => ['required'],
            'paymentDescription' => ['required', 'string', 'max:255']
        ]);

        $data = [
            'msisdn' => $validated['msisdn'],
            'amount' => $validated['amount'],
            'serviceProviderCode' => $validated['serviceProviderCode'],
            'transaction_ID' => $validated['transaction_ID'],
            'reference' => $validated['reference'],
            'paymentDescription' => $validated['paymentDescription'],
        ];

        $response = (new VodacomMpesa)->authenticate()->USSDPush($data);
        
        return $response;
    }



    public function processPayment(Request $request) {

        $request->validate([

        ]);

        $data = [
            'Amount' => $request->amount,
            'Fuel amount' => $request->fuelAmount,
            'Fue Type' => $request->fuelName,
            'User' => $request->user,
            'Phonenumber' => $request->phoneNumber
        ];

        return [
            'data' => $data,
            'message' => 'Request received successfully'
        ];
    }
}
