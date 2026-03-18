<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('hero_slides', function (Blueprint $table): void {
      $table->id();
      $table->string('tag');
      $table->string('heading');
      $table->text('subtitle');
      $table->string('illustration')->nullable();   // uploaded image path
      $table->string('bg_gradient')->default('linear-gradient(135deg, #06091a 0%, #0d1130 50%, #151845 100%)');
      $table->string('glow_color')->default('rgba(99, 102, 241, 0.45)');
      $table->unsignedTinyInteger('sort_order')->default(0);
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    // Seed the 3 default slides
    DB::table('hero_slides')->insert([
      [
        'tag'          => 'Web Development',
        'heading'      => 'Building Digital Products That Drive Business Forward',
        'subtitle'     => 'Custom websites and web applications engineered for performance, scalability, and real results.',
        'illustration' => null,
        'bg_gradient'  => 'linear-gradient(135deg, #06091a 0%, #0d1130 50%, #151845 100%)',
        'glow_color'   => 'rgba(99, 102, 241, 0.45)',
        'sort_order'   => 1,
        'is_active'    => true,
        'created_at'   => now(),
        'updated_at'   => now(),
      ],
      [
        'tag'          => 'Mobile Development',
        'heading'      => 'Mobile Apps Built for the Way People Actually Live',
        'subtitle'     => 'Cross-platform iOS & Android experiences with seamless UX and secure, scalable backends.',
        'illustration' => null,
        'bg_gradient'  => 'linear-gradient(135deg, #0b0718 0%, #16102e 50%, #1e1040 100%)',
        'glow_color'   => 'rgba(139, 92, 246, 0.45)',
        'sort_order'   => 2,
        'is_active'    => true,
        'created_at'   => now(),
        'updated_at'   => now(),
      ],
      [
        'tag'          => 'Data Solutions',
        'heading'      => 'Turn Your Data Into Your Competitive Advantage',
        'subtitle'     => 'Intelligent dashboards and analytics tools that give your team insights to make confident decisions.',
        'illustration' => null,
        'bg_gradient'  => 'linear-gradient(135deg, #060e18 0%, #0b1a2e 50%, #0d2040 100%)',
        'glow_color'   => 'rgba(14, 165, 233, 0.42)',
        'sort_order'   => 3,
        'is_active'    => true,
        'created_at'   => now(),
        'updated_at'   => now(),
      ],
    ]);
  }

  public function down(): void
  {
    Schema::dropIfExists('hero_slides');
  }
};
