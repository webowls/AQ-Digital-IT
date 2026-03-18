<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'featured_image',
    'gallery',
    'content',
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
