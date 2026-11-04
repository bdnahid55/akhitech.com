<?php

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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('content')->nullable();
            $table->string('banner_image')->nullable();

            // Navigation Placement
            $table->boolean('show_in_header')->default(false);
            $table->foreignId('header_parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->boolean('show_in_footer')->default(false);
            $table->string('footer_column')->default('quick_links'); // 'quick_links' or 'legal'
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
