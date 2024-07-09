<?php

namespace App\Models;

use DateTime;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public string $id;
    public string $name;
    public float $price;
    public string $description;
    public DateTimeImmutable $createdAt;
    public DateTime $updatedAt;

    use HasFactory;
}
