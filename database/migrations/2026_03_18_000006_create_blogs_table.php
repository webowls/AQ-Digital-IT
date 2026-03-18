<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('blogs', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('slug')->unique();
      $table->string('featured_image')->nullable();
      $table->json('gallery')->nullable();
      $table->longText('content');
      $table->text('tags')->nullable();
      $table->string('meta_title')->nullable();
      $table->text('meta_description')->nullable();
      $table->text('meta_keywords')->nullable();
      $table->boolean('is_published')->default(true);
      $table->timestamp('published_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('blogs');
  }
};
