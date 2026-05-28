<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('company_name', 160)->nullable();
            $table->string('email', 190);
            $table->string('phone', 60)->nullable();
            $table->string('existing_website_url', 255)->nullable();
            $table->string('project_type', 50);
            $table->string('timeline', 120)->nullable();
            $table->string('budget_range', 120)->nullable();
            $table->string('multilingual_needs', 255)->nullable();
            $table->string('content_admin_needs', 255)->nullable();
            $table->text('project_description');
            $table->boolean('gdpr_consent')->default(false);
            $table->string('source', 500)->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
