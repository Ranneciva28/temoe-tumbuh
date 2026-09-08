<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->string('form_key')->default('interest')->index();
            $table->string('section_key')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_protected')->default(false);
            $table->timestamps();

            $table->unique(['form_key', 'section_key']);
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->string('section_key')->nullable()->after('form_key')->index();
        });

        $storedTitles = DB::table('settings')
            ->where('group', 'interest_form')
            ->whereIn('key', [
                'parent_section_title',
                'child_section_title',
                'daycare_section_title',
                'additional_section_title',
            ])
            ->pluck('value', 'key');

        $now = now();
        DB::table('form_sections')->insert([
            [
                'form_key' => 'interest',
                'section_key' => 'parent',
                'title' => $storedTitles['parent_section_title'] ?? '1. Tentang Moms',
                'description' => null,
                'sort_order' => 10,
                'is_active' => true,
                'is_protected' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'form_key' => 'interest',
                'section_key' => 'child',
                'title' => $storedTitles['child_section_title'] ?? '2. Tentang si kecil & lokasi',
                'description' => null,
                'sort_order' => 20,
                'is_active' => true,
                'is_protected' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'form_key' => 'interest',
                'section_key' => 'daycare',
                'title' => $storedTitles['daycare_section_title'] ?? '3. Kebutuhan daycare',
                'description' => null,
                'sort_order' => 30,
                'is_active' => true,
                'is_protected' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'form_key' => 'interest',
                'section_key' => 'additional',
                'title' => $storedTitles['additional_section_title'] ?? '4. Sedikit lagi, Moms',
                'description' => null,
                'sort_order' => 40,
                'is_active' => true,
                'is_protected' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'form_key' => 'interest',
                'section_key' => 'consent',
                'title' => 'Persetujuan',
                'description' => null,
                'sort_order' => 50,
                'is_active' => true,
                'is_protected' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('form_fields')
            ->where('form_key', 'interest')
            ->whereNull('section_key')
            ->update(['section_key' => 'additional']);
    }

    public function down(): void
    {
        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropColumn('section_key');
        });

        Schema::dropIfExists('form_sections');
    }
};
