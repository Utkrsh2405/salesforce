<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['call', 'email', 'meeting', 'task', 'note']);
            $table->string('subject');
            $table->text('description')->nullable();
            $table->dateTime('due_date');
            $table->dateTime('due_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('related_to_type', ['lead', 'contact', 'company', 'deal']);
            $table->unsignedBigInteger('related_to_id');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('completed_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->string('location')->nullable();
            $table->json('attendees')->nullable();
            $table->text('outcome')->nullable();
            $table->string('next_action')->nullable();
            $table->boolean('is_billable')->default(false);
            $table->decimal('billable_hours', 4, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
