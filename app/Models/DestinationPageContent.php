<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationPageContent extends Model
{
  use HasFactory;
  public function getTabDetail()
  {
    return $this->hasOne(DestinationPageTab::class, 'id', 'tab_id');
  }
}
