<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
  protected $fillable = [
    'tag',
    'heading',
    'subtitle',
    'illustration',
    'bg_gradient',
    'glow_color',
    'sort_order',
    'is_active',
  ];

  protected $casts = [
    'is_active'  => 'boolean',
    'sort_order' => 'integer',
  ];
}
