<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasUuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'type',
        'conditions',
        'is_active'
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "user_badges")
            ->withPivot("earned_at")
            ->withTimestamps();
    }
}
