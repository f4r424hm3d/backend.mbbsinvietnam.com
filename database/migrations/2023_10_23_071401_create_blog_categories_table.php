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
    Schema::create('blog_categories', function (Blueprint $table) {
      $table->id();
      $table->string('category_name', 100);
      $table->string('category_slug', 100);
      $table->text('shortnote')->nullable();
      $table->text('imgae_name')->nullable();
      $table->text('image_path')->nullable();
      $table->text('banner_name')->nullable();
      $table->text('banner_path')->nullable();
      $table->string('meta_title', 200)->nullable();
      $table->longText('meta_keyword')->nullable();
      $table->longText('meta_description')->nullable();
      $table->text('page_content')->nullable();
      $table->integer('seo_rating')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blog_categories');
  }
};
