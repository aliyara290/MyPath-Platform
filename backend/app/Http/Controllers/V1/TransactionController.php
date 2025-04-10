<?php

namespace App\Http\Controllers\V1;

use App\Models\Transaction;
use App\Http\Requests\V1\StoreTransactionRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\TransactionInterface;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;

class TransactionController extends Controller
{

    use HttpResponses;

    private $transactionRepository;

    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createIntent(StoreTransactionRequest $request)
    {
        Stripe::setApiKey(config("services.strip.secret"));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => $request->currency,
                'metadata' => ['user_id' => $request->userId]
            ]);
            $userId = Auth::id();
            $transaction = $this->transactionRepository->create([
                "user_id" => $userId,
                "strip_payment_intent" => $userId,
                "amount" => $request->amount,
                "currency" => $request->currency,
                "status" => 'pending'
            ]);
            return response()->json([
                "payment_intent" => $paymentIntent->client_secret,
                "transaction_id" => $transaction->id
            ]);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e->getMessage()
            );
        }
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, config('services.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    $this->transactionRepository->updateStatus($paymentIntent->id, 'succeeded');
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    $this->transactionRepository->updateStatus($paymentIntent->id, 'failed');
                    break;
            }

            return response()->json(['message' => 'Webhook processed'], 200);
        } catch (Exception $e) {
            Log::error('Webhook handling failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid webhook'], 400);
        }
    }
}
