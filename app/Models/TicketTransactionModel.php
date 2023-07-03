<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TicketTransactionModel extends Model
{
    use HasFactory;

    protected $table = "ticket_transaction_history";

    protected $fillable = [
        'user_id',
        'xid',
        'movie_title',
        'movie_age_rating',
        'seat_number',
        'status',
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