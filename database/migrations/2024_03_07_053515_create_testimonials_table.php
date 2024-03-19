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
    Schema::create('testimonials', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->text('review');
      $table->string('image_name', 100)->nullable();
      $table->text('image_path')->nullable();
      $table->string('country', 100)->nullable();
      $table->string('designation', 100)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('testimonials');
  }
};
