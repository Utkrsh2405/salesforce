<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('job_title')->nullable();
            $table->foreignId('lead_source_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('lead_status_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->integer('probability')->nullable();
            $table->date('expected_close_date')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-1000', '1000+'])->nullable();
            $table->string('budget_range')->nullable();
            $table->text('pain_points')->nullable();
            $table->json('decision_makers')->nullable();
            $table->json('communication_history')->nullable();
            $table->integer('lead_score')->nullable();
            $table->timestamp('conversion_date')->nullable();
            $table->json('tags')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
