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
    Schema::create('portfolios', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('category')->nullable();
      $table->text('description');
      $table->string('project_url')->nullable();
      $table->string('featured_image')->nullable();
      $table->json('gallery')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('portfolios');
  }
};
