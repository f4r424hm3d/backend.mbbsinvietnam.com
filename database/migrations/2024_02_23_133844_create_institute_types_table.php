<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('institute_types', function (Blueprint $table) {
      $table->id();
      $table->string('type', 100);
      $table->string('slug', 100);
      $table->string('seo_title', 100);
      $table->string('seo_title_slug', 100);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('institute_types');
  }
};
