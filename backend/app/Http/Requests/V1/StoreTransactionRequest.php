<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "userId" => ["required", "exists:users,id"],
            "amount" => ["required", "min:1", "numeric"],
            "stripPaymentIntent" => ["string", "unique:transaction,strip_payment_intent"],
            "currency" => ["required", "string"],
            "status" => ["string", "in:pending,succeeded,failed"],
            "metadata" => ["nullable", "json"],
            "payment_method" => ["string", "nullable"]
        ];
    }
}
