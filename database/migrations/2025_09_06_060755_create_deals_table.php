<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deal_stage_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('deal_value', 15, 2);
            $table->integer('probability')->nullable();
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            $table->foreignId('deal_source_id')->nullable()->constrained()->onDelete('set null');
            $table->text('competitor_info')->nullable();
            $table->text('description')->nullable();
            $table->json('products')->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->boolean('is_won')->default(false);
            $table->string('lost_reason')->nullable();
            $table->json('tags')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
