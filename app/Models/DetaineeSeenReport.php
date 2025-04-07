<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetaineeSeenReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'detainee_id',
        'user_id',
        'location',
        'details',
        'contact',
    ];

    /**
     * Get the user who submitted the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * Get the detainee related to this report.
     */
    public function detainee()
    {
        return $this->belongsTo(Detainee::class);
    }
}
