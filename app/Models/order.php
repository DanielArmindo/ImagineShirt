<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'status',
        'customer_id',
        'date',
        'total_price',
        'notes',
        'nif',
        'address',
        'payment_type',
        'payment_ref',
        'receipt_url'
    ];

    function orderitemRef(): hasMany
    {
        return $this->hasMany(order_item::class, 'order_id', 'id');
    }
    function customerRef(): BelongsTo
    {
        return $this->belongsTo(customer::class, 'customer_id', 'id')->withTrashed();
    }
}
