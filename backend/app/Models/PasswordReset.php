<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    protected $fillable = [
        'email', 'token'
    ];
    public $incrementing = false;
    public $timestamps = false;
    public $primaryKey = 'email';


    public function setCreatedAtAttribute($value) {
        $this->attributes['created_at'] = Carbon::now();
    }
}
