<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Shop
 *
 * @mixin Eloquent
 *
 * @property string $shop_id,
 * @property string $api_key,
 * @property string $domain
 */
class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'api_key',
        'domain',
    ];
}
