<?php

namespace App\Enum;

enum TicketStatusEnum: int
{
    case SUCCESS = 1;
    case CANCELED = 2;
}