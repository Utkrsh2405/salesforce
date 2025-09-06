<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-1000', '1000+'])->nullable();
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->json('billing_address')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->json('social_media_links')->nullable();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('source_id')->nullable()->constrained('lead_sources')->onDelete('set null');
            $table->json('tags')->nullable();
            $table->json('custom_fields')->nullable();
            $table->boolean('is_client')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
