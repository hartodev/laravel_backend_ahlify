<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
      protected $guarded = [];
        public function partnerProfile()
    {
        return $this->belongsTo(PartnerProfile::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
