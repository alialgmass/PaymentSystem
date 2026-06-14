<?php

namespace App\Models;

use Database\Factories\WebHookEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'event_type',
    'payload',
    'status',
    'response_code',
    'response_body',
    'attempt_count',
    'max_attempts',
    'processed_at',
])]
class WebHookEvent extends Model
{
    /** @use HasFactory<WebHookEventFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'processed_at' => 'datetime',
        ];
    }
}
