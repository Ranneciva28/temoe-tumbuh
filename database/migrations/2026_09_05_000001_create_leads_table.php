<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('whatsapp', 30)->index();
            $table->string('email')->nullable();
            $table->string('child_name')->nullable();
            $table->unsignedTinyInteger('child_age')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('district')->nullable();
            $table->string('preferred_location')->nullable();
            $table->string('preferred_schedule')->nullable();
            $table->date('preferred_start_date')->nullable();
            $table->string('budget_range')->nullable();
            $table->boolean('reservation_interest')->default(false)->index();
            $table->enum('status', ['new','contacted','qualified','high_intent','reserved','lost'])->default('new')->index();
            $table->text('notes')->nullable();

            $table->string('utm_source')->nullable()->index();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable()->index();
            $table->string('utm_content')->nullable();
            $table->string('utm_term')->nullable();
            $table->text('fbclid')->nullable();
            $table->text('gclid')->nullable();
            $table->text('referrer')->nullable();
            $table->text('landing_page')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
