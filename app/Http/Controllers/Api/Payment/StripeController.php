<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
class StripeController extends Controller
{
        //api stripe payment
    public function store(Request $request)
    {
        try {
            /* Create a card token */
              $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
              );
              $info =   $stripe->tokens->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' =>  $request->exp_month,
                        'exp_year' =>  $request->exp_year,
                        'cvc' =>  $request->cvc,
                    ],
                ]);

              /* Create a charge */
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          $res =   $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $info->id,
                'description' => 'Test Charge',
            ]);
            return  response()->json($res,201);
        }catch (\Exception $ex){
            return response()->json(['error'=> $ex->getMessage()],500);
        }

    }


}
