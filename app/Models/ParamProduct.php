<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ParamProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamProduct extends Model
{
    /** @use HasFactory<ParamProductFactory> */
    use HasFactory;
}
