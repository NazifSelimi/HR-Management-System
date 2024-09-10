<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    // $casts property
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
    ];

    // $appends property to match the accessor method name
    protected $appends = ['formatted_start_date', 'formatted_end_date'];

    // accessor for formatted start date
    protected function formattedStartDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_date ? Carbon::parse($this->start_date)->format('d M Y') : 'Pending',
        );
    }

    protected function formattedEndDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->end_date ? Carbon::parse($this->end_date)->format('d M Y') : 'Pending',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
