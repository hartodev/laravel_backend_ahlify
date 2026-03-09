<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function partnerProfiles()
    {
        return $this->hasMany(PartnerProfile::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
