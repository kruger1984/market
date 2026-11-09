<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ParamProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParamProduct extends Model
{
    /** @use HasFactory<ParamProductFactory> */
    use HasFactory;

    //    /**
    //     * @return BelongsTo<Param, $this>
    //     */
    //    public function param(): BelongsTo
    //    {
    //        return $this->belongsTo(Param::class);
    //    }
    //
    //    /**
    //     * @return BelongsTo<Product, $this>
    //     */
    //    public function product(): BelongsTo
    //    {
    //        return $this->belongsTo(Product::class);
    //    }
}
