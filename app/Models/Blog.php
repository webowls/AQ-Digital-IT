<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'featured_image',
    'gallery',
    'content',
    'tags',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'is_published',
    'published_at',
  ];

  protected function casts(): array
  {
    return [
      'gallery' => 'array',
      'is_published' => 'boolean',
      'published_at' => 'datetime',
    ];
  }

  public function tagList(): array
  {
    if (! $this->tags) {
      return [];
    }

    return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
  }
}
