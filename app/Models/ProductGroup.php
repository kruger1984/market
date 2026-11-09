<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    /** @use HasFactory<ProductGroupFactory> */
    use HasFactory;
}
