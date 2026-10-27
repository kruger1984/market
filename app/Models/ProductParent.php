<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductParentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductParent extends Model
{
    /** @use HasFactory<ProductParentFactory> */
    use HasFactory;
}
