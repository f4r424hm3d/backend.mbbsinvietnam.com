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
    Schema::create('university_overviews', function (Blueprint $table) {
      $table->id();
      $table->text('title', 20);
      $table->longText('description')->nullable();
      $table->string('image_name', 200)->nullable();
      $table->text('image_path')->nullable();
      $table->unsignedBigInteger('university_id')->nullable();
      $table->foreign('university_id')->references('id')->on('universities')->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('university_overviews');
  }
};
