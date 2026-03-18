<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('services', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('featured_image')->nullable();
      $table->json('gallery')->nullable();
      $table->longText('content');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('services');
  }
};
