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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->string('sku')->unique();
            $table->decimal('price');
            $table->decimal('old_price')->nullable();
            $table->unsignedInteger('qty');
            $table->foreignId('product_group_id')->index()->constrained('product_groups');
            $table->foreignId('category_id')->index()->constrained('categories');

            $table->foreignId('parent_id')->index()->nullable()->constrained('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
