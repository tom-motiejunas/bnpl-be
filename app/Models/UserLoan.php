<?php

namespace App\Models;

use DateTime;
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
 * @property int $user_id
 * @property string $purchase_id,
 * @property DateTime $last_payment,
 * @property DateTime $next_payment,
 * @property int $amount,
 * @property int $total_paid,
 * @property int $instalment,
 * @property int $total_instalments,
 * @property string $paymentMethodId
 */
class UserLoan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'user_loan';

    protected $fillable = [
        'user_id',
        'purchase_id',
        'last_payment',
        'next_payment',
        'amount',
        'total_paid',
        'instalment',
        'total_instalments',
        'paymentMethodId',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'total_paid' => 0,
        'instalment' => 1,
        'total_instalments' => 4,
    ];

    /**
     * @return BelongsTo<User, UserLoan>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
