<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TopUpBalanceHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'top_up_balance_history';

    protected $fillable = [
        'user_id',
        'amount',
        'notes',
    ];

    /**
     * Get the user that owns the TopUpBalanceHistoryModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
