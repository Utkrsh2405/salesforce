<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number', 50)->unique();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('deal_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->date('quote_date');
            $table->date('valid_until');
            $table->enum('status', ['draft', 'sent', 'accepted', 'declined', 'expired'])->default('draft');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->text('signature_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
