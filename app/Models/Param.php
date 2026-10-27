<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ParamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    /** @use HasFactory<ParamFactory> */
    use HasFactory;
}
