<?php

namespace App\Enums;

enum ReviewStatus: string
{
    case PUBLIC = '公開';
    case PRIVATE = '非公開';
    case PENDING = '保留';
}
