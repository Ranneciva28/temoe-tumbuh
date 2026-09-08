<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meta_event_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 100);
            $table->string('trigger_type', 40)->index();
            $table->string('target_key', 150)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->unique(['event_name', 'trigger_type', 'target_key'], 'meta_event_mapping_unique');
        });

        Schema::create('meta_event_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meta_event_mapping_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_name', 100)->index();
            $table->string('trigger_type', 40)->index();
            $table->string('target_key', 150)->index();
            $table->string('event_id', 180);
            $table->string('channel', 30)->index();
            $table->string('status', 40)->index();
            $table->text('page_url')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['channel', 'event_id'], 'meta_event_log_delivery_unique');
        });

        $defaults = [
            ['PageView', 'page_view', 'page_home'],
            ['PageView', 'page_view', 'page_interest'],
            ['PageView', 'page_view', 'page_thank_you'],
            ['PageView', 'page_view', 'page_privacy'],
            ['ViewContent', 'click', 'home'],
            ['ViewContent', 'click', 'program'],
            ['ViewContent', 'click', 'experience'],
            ['ViewContent', 'click', 'pricing'],
            ['ViewContent', 'click', 'parents'],
            ['ViewContent', 'click', 'faq'],
            ['Contact', 'click', 'sticky_nav_interest'],
            ['Contact', 'click', 'hero_priority_slot'],
            ['ViewContent', 'click', 'hero_daily_experience'],
            ['Contact', 'click', 'pricing_interest'],
            ['Contact', 'click', 'family_fit_interest'],
            ['ViewContent', 'click', 'location'],
            ['ViewContent', 'click', 'age'],
            ['ViewContent', 'click', 'schedule'],
            ['ViewContent', 'click', 'price'],
            ['ViewContent', 'click', 'commitment'],
            ['Contact', 'click', 'final_interest'],
            ['ViewContent', 'click', 'interest_back_home'],
            ['ViewContent', 'click', 'thank_you_home'],
            ['SubmitApplication', 'form_submit', 'interest_form_submit'],
            ['Lead', 'form_success', 'interest_form_success'],
        ];

        $now = now();
        DB::table('meta_event_mappings')->insert(array_map(fn ($mapping) => [
            'event_name' => $mapping[0],
            'trigger_type' => $mapping[1],
            'target_key' => $mapping[2],
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ], $defaults));
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_event_logs');
        Schema::dropIfExists('meta_event_mappings');
    }
};
