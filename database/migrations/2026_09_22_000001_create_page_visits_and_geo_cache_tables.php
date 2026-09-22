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
        Schema::create('ip_geo_caches', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->unique();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->default('Guest');
            $table->string('page_name')->index();
            $table->text('url')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->string('product_title')->nullable();
            $table->string('quote_request_id')->nullable();
            $table->string('ip')->index();
            $table->string('browser')->default('Other')->index();
            $table->string('platform')->default('Other')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_visits');
        Schema::dropIfExists('ip_geo_caches');
    }
};
