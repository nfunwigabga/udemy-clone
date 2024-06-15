<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case CREATED = 'created';
    case REFUNDED = 'refunded';
    case FINALIZED = 'finalized';
}
