<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Shop
 *
 * @property string $id,
 * @property string $api_key,
 * @property string $domain
 */
class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'api_key',
        'domain',
    ];
}
