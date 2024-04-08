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
    Schema::create('dynamic_pages', function (Blueprint $table) {
      $table->id();
      $table->string('page_name', 200);
      $table->string('slug', 200);
      $table->string('country', 100)->nullable();
      $table->string('course_duration', 100)->nullable();
      $table->string('neet', 100)->nullable();
      $table->string('english_profiency_exam', 100)->nullable();
      $table->string('intake', 100)->nullable();
      $table->string('eligibility', 100)->nullable();
      $table->string('medium_of_teaching', 100)->nullable();
      $table->string('image_name', 200)->nullable();
      $table->text('image_path')->nullable();
      $table->text('thumbnail')->nullable();
      $table->longText('top_description')->nullable();
      $table->longText('bottom_description')->nullable();
      $table->boolean('status')->default(1);
      $table->text('meta_title')->nullable();
      $table->longText('meta_keyword')->nullable();
      $table->longText('meta_description')->nullable();
      $table->string('page_content', 100)->nullable();
      $table->integer('seo_rating')->nullable();
      $table->unsignedBigInteger('author_id')->nullable();
      $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dynamic_pages');
  }
};
