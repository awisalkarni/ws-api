<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_code',
        'year',
        'status',
        'records_created',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'records_created' => 'integer',
        ];
    }
}
