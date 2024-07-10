<?php

namespace App\Models;

use DateTime;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    private string $id;
    private string $name;
    private float $price;
    private string $description;
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    use HasFactory;
}
