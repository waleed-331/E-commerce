<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static where(string $string, $id)
 */
class Product extends Model
{
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');

    }
    public function category()
    {
        return $this->belongsTo(Category::class ,"category_id" , "id" );
    }
    protected $casts =[
        'periods' => 'array',
        'discounts' => 'array',
    ];
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'details',
        'views',
        'expiration_date',
        'quantity',
        'periods',
        'discounts',
        'category_id',
        'phone',
        'facebook',
        'price',
        'price_after_discount',
    ];

}
