<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
  use HasFactory;
  public function author()
  {
    return $this->hasOne(User::class, 'id', 'author_id');
  }
}
