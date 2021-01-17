<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory,UsesUuid;
    protected $table = 'otp';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
