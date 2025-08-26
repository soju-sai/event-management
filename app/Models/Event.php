<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;
    //
    protected $fillable = ['name', 'description', 'start_time', 'end_time', 'user_id'];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }
}
