<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'category',
    'description',
    'project_url',
    'featured_image',
    'gallery',
    'is_active',
  ];

  protected function casts(): array
  {
    return [
      'gallery' => 'array',
      'is_active' => 'boolean',
    ];
  }
}
