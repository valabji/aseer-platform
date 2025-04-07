<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetaineeErrorReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'detainee_id',
        'user_id',
        'details',
        'contact_info',
    ];

    /**
     * العلاقة مع المستخدم الذي أبلغ.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * العلاقة مع الأسير المُبلّغ عنه.
     */
    public function detainee()
    {
        return $this->belongsTo(Detainee::class);
    }
}
