<?php

namespace App\Models\Types;

enum PaymentType: string
{
    case PERIOIC = 'periodic';
    case IMEDIATE = 'imediate';
}
