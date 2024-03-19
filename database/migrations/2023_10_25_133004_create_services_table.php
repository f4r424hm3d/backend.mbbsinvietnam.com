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
    Schema::create('services', function (Blueprint $table) {
      $table->id();
      $table->string('service_name');
      $table->string('service_slug');
      $table->longText('description')->nullable();
      $table->longText('description_bottom')->nullable();
      $table->unsignedBigInteger('parent_id')->nullable();
      $table->foreign('parent_id')->references('id')->on('treatments')->nullOnDelete();
      $table->unsignedBigInteger('author_id')->nullable();
      $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
      $table->text('image_name')->nullable();
      $table->text('image_path')->nullable();
      $table->integer('position')->default(1);
      $table->text('meta_title')->nullable();
      $table->longText('meta_keyword')->nullable();
      $table->longText('meta_description')->nullable();
      $table->string('page_content', 100)->nullable();
      $table->text('og_image_path')->nullable();
      $table->text('seo_rating')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('services');
  }
};
