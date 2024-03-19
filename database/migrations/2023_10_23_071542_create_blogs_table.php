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
    Schema::create('blogs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('category_id');
      $table->foreign('category_id')->references('id')->on('blog_categories');
      $table->text('title');
      $table->text('slug');
      $table->longText('description')->nullable();
      $table->text('thumbnail_name')->nullable();
      $table->text('thumbnail_path')->nullable();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->bigInteger('views')->nullable();
      $table->string('rating')->nullable();
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
    Schema::dropIfExists('blogs');
  }
};
