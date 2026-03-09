<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVirtualAccount extends Model
{
    use HasFactory;
      protected $guarded = [];
       protected $casts = [
        'expired_date' => 'datetime',
        'raw_create_request' => 'array',
        'raw_create_response' => 'array',
        'raw_callback_payload' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
