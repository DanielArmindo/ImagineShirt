<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class order_item extends Model
{
    use HasFactory;
    protected $table ='order_items';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'tshirt_image_id',
        'color_code',
        'size',
        'qty',
        'unit_price',
        'sub_total',
    ];

    function tshirt_imageRef():BelongsTo
    {
        return $this->belongsTo(tshirt_image::class, 'tshirt_image_id','id')->withTrashed();
    }

    function orderRef(): BelongsTo
    {
        return $this->belongsTo(order::class, 'order_id', 'id');
    }

    function colorRef(): BelongsTo
    {
        return $this->belongsTo(color::class, 'color_code', 'code')->withTrashed();
    }
}
