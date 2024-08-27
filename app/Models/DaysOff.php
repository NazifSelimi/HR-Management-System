<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaysOff extends Model
{
    use HasFactory;

    protected $table = 'days_off';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'reason',
        'type',
        'status',

    ];

    public function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'status' => 'boolean',
        ];

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
