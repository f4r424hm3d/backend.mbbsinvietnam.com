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
    Schema::create('dynamic_page_galleries', function (Blueprint $table) {
      $table->id();
      $table->string('title', 200);
      $table->string('image_name', 200)->nullable();
      $table->text('image_path')->nullable();
      $table->unsignedBigInteger('page_id')->nullable();
      $table->foreign('page_id')->references('id')->on('dynamic_pages')->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dynamic_page_galleries');
  }
};
