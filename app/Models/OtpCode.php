<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class OtpCode extends Model
{
    use HasFactory, UsesUuid;

    // customs
    protected $guarded = [];
}
