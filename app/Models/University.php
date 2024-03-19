<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function getInstType()
  {
    return $this->hasOne(InstituteType::class, 'id', 'institute_type');
  }
  public function getAuthor()
  {
    return $this->hasOne(User::class, 'id', 'author_id');
  }
  public function getDestination()
  {
    return $this->hasOne(Destination::class, 'id', 'destination_id');
  }
}
