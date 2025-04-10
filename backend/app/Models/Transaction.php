<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuid;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "user_id",
        "strip_payment_intent",
        "status",
        "amount",
        "metadata",
        "currency",
        "payment_method"
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }
}
