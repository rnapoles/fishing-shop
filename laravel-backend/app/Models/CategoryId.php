<?php

namespace App\Models;

enum CategoryId: int
{
    case LowRange = 1;
    case MidRange = 2;
    case HightRange = 3;
}
