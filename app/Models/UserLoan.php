<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * User
 *
 * @property int $user_id
 * @property string $order_id,
 * @property DateTime $last_payment,
 * @property DateTime $next_payment,
 * @property int $amount,
 * @property float $total,
 * @property float $total_paid,
 * @property int $instalment,
 * @property int $total_instalment,
 * @property string $payment_method_id
 */
class UserLoan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'user_loans';

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
        'shop_id',
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

    /**
     * @return BelongsTo<Shop, UserLoan>
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
