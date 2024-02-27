<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class tshirt_image extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tshirt_images';

    protected $fillable = [
        'customer_id',
        'category_id',
        'name',
        'description',
        'image_url',
        'extra_info',
    ];

    function order_itemRef(): HasMany
    {
        return $this->hasMany(order_item::class, 'tshirt_image_id', 'id');
    }
    function categorieRef(): BelongsTo
    {
        return $this->belongsTo(categorie::class, 'category_id', 'id')->withTrashed();
    }
    function customerRef(): BelongsTo
    {
        return $this->belongsTo(customer::class, 'customer_id', 'id');
    }
}
