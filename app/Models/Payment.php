<?php

namespace App\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    private string $id;
    private float $total;
    private DateTimeImmutable $paidAt;
    private PaymentType $type;
    private string $notes;

    use HasFactory;
}


enum PaymentType: string
{
    case PERIOIC = 'periodic';
    case DAILY = 'daily';
}
