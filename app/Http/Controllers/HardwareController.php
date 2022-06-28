<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;


class HardwareController extends Controller
{
    

    public function getAccessCode(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'min:4'],
            'status' => ['required'],
        ]);

        $transaction = Transaction::where('access_token', $validated['code'])->first();

        if($validated['status'] == 'active')
        {
            if($transaction == NULL || $transaction->status == FALSE)
            {
                return [
                    'Error' => 'Invalid access token!'
                ];
            }

            $data = [
                'fuel' => $transaction->litres,
                'type' => $transaction->fuel->name,
                'name' => $transaction->user->name,
            ];

            return $data;

        }
        elseif( $validated['status'] == 'inactive')
        {

            if($transaction == NULL || $transaction->status == FALSE)
            {
                return [
                    'Error' => 'Invalid access token!'
                ];
            }

            $transaction->status = FALSE;
            $transaction->save();

            return [
                'message' => 'Updated',
                'transaction' => $transaction,
            ];
        } else {
            return [
                'Error' => 'Invalid access token!'
            ];
        }

    }
}