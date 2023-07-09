<?php

namespace App\Repositories;

use App\Enum\TicketStatusEnum;
use App\Models\TicketTransactionModel;
use Hidehalo\Nanoid\Client;

class EloquentTicketTransactionRepository
{
    private $clientNanoId;

    public function __construct(Client $clientNanoId)
    {
        $this->clientNanoId = $clientNanoId;
    }

    public function getLatestTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
    }

    public function getAllTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(9);
    }

    public function getAllBookedSeats($movieTitle)
    {
        return TicketTransactionModel::where([
            ['status', TicketStatusEnum::SUCCESS],
            ['movie_title', $movieTitle]
        ])->get();
    }

    public function getBookedSeatsByUser($movieTitle, $userId)
    {
        return count(TicketTransactionModel::where([
            ['user_id', $userId],
            ['movie_title', $movieTitle],
            ['status', TicketStatusEnum::SUCCESS->value],
        ])->get());
    }

    public function getUserTotalTicketPerFilm($movieTitle)
    {
        return count(TicketTransactionModel::where([
            ['status', TicketStatusEnum::SUCCESS],
            ['movie_title', $movieTitle],
            ['user_id', auth()->user()->id]
        ])->get());
    }

    public function storeBuyTicketData($request, $seatNumber)
    {
        TicketTransactionModel::create([
            'user_id' => auth()->user()->id,
            'xid' => $this->clientNanoId->generateId($size = 10),
            'movie_title' => $request->movie_title,
            'movie_age_rating' => $request->movie_age_rating,
            'ticket_price' => $request->ticket_price,
            'seat_number' => $seatNumber,
            'status' => TicketStatusEnum::SUCCESS,
        ]);
    }

    public function getTicketDetail($ticketXId)
    {
        return  TicketTransactionModel::where('xid', $ticketXId)->first();
    }

    public function cancelBuyTicket($ticketXId)
    {
        TicketTransactionModel::where('xid', $ticketXId)->update(['status' => TicketStatusEnum::CANCELED]);
    }
}