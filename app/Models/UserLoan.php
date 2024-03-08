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
 * @property string $order_id,
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
        'order_id',
        'payment_method_id',
        'last_payment',
        'next_payment',
        'total',
        'total_paid',
        'instalment',
        'total_instalment',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'instalment' => 1,
        'total_instalment' => 4,
    ];

    /**
     * @return BelongsTo<User, UserLoan>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
