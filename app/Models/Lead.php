<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
  use HasFactory;
  public function getTreatment()
  {
    return $this->hasOne(Treatment::class, 'id', 'treatment_id');
  }
}
