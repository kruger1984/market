<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_user_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained('products');
            $table->foreignId('user_id')->index()->constrained('users');
            $table->foreignId('order_id')->index()->nullable()->constrained('orders');
            $table->unsignedInteger('qty');
            $table->unsignedSmallInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_user_cards');
    }
};
