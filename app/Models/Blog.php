<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  use HasFactory;
  public function getCategory()
  {
    return $this->hasOne(BlogCategory::class, 'id', 'category_id');
  }
  public function getUser()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
}
