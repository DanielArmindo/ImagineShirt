<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customers';

    protected $fillable = ['id','nif','address','default_payment_type','default_payment_ref'];

    public function userRef(): HasOne
    {
        return $this->hasOne(User::class, 'id','id')->withTrashed();
    }

    function orderRef(): HasMany
    {
        return $this->hasMany(order::class, 'id', 'customer_id')->withTrashed();
    }
}
