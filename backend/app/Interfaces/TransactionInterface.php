<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function create(array $data);
    public function findByIntent(string $paymentIntent);
    public function updateStatus(string $paymentIntent, string $status);
    public function getUserTransaction(int $userId);
}
