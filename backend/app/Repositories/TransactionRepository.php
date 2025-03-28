<?php

namespace App\Repositories;

use App\Interfaces\TransactionInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionInterface
{
    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function findByIntent(string $paymentIntent)
    {
        return Transaction::where("strip_payment_intent", $paymentIntent)->first();
    }

    public function updateStatus(string $paymentIntent, string $status)
    {
        return Transaction::where("strip_payment_intent", $paymentIntent)->update(["status" => $status]);
    }

    public function getUserTransaction(int $userId)
    {
        return Transaction::where("user_id", $userId)->get();
    }
}
