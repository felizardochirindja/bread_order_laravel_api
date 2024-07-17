<?php

namespace App\Models;

use App\Models\Types\PaymentType;
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
