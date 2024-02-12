<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * User
 *
 * @mixin Eloquent
 *
 * @property string $email
 * @property string $password
 */
class UserLoan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'purchase_id',
        'last_payment',
        'next_payment',
        'amount',
        'total_paid',
        'instalment',
        'total_instalments',
    ];

    /**
     * @return BelongsTo<User, UserLoan>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
