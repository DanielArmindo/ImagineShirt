<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class categorie extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    public $timestamps = false;

    function tshirt_imageRef():HasMany
    {
        return $this->hasMany(tshirt_image::class, 'id','category_id')->withTrashed();
    }
}
