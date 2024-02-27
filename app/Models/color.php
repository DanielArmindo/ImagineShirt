<?php

namespace App\Models;

use App\Models\order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class color extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'colors';
    public $timestamps = false;
    protected $primaryKey  = 'code';
    protected $keyType = 'string';

    protected $fillable = [
        'code'
    ];

    function orderItemRef(): HasMany {
        return $this->hasMany(order_item::class, 'color_code', 'code');
    }
}
