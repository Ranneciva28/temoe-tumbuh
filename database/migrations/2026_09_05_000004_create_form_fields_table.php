<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('form_key')->default('interest')->index();
            $table->string('field_key')->index();
            $table->string('label');
            $table->enum('type', ['text','email','tel','number','date','select','radio','checkbox','textarea','hidden'])->default('text');
            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('validation_rules')->nullable();
            $table->timestamps();

            $table->unique(['form_key', 'field_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
