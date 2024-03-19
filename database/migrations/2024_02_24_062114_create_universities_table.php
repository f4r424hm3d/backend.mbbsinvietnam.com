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
    Schema::create('universities', function (Blueprint $table) {
      $table->id();
      $table->string('name', 200);
      $table->string('slug', 200);
      $table->string('university_name', 200)->nullable();
      $table->string('university_name_slug', 200)->nullable();
      $table->string('code', 20)->nullable();
      $table->string('views', 200)->nullable();
      $table->string('country', 200)->nullable();
      $table->string('country_slug', 200)->nullable();
      $table->string('state', 20)->nullable();
      $table->string('city', 20)->nullable();
      $table->string('rank', 20)->nullable();
      $table->string('established_year', 10)->nullable();
      $table->longText('shortnote')->nullable();
      $table->longText('overview', 20)->nullable();
      $table->boolean('status')->default(1);
      $table->boolean('homeview')->default(0);
      $table->integer('click')->nullable();
      $table->string('qs_rank', 20)->nullable();
      $table->string('times_rank', 20)->nullable();
      $table->string('image_name', 200)->nullable();
      $table->text('image_path')->nullable();
      $table->string('banner_name', 200)->nullable();
      $table->text('banner_path')->nullable();
      $table->string('brochure_name', 200)->nullable();
      $table->text('brochure_path')->nullable();
      $table->unsignedBigInteger('destination_id')->nullable();
      $table->foreign('destination_id')->references('id')->on('destinations')->nullOnDelete();
      $table->unsignedBigInteger('author_id')->nullable();
      $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
      $table->unsignedBigInteger('institute_type')->nullable();
      $table->foreign('institute_type')->references('id')->on('institute_types')->nullOnDelete();
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
    Schema::dropIfExists('universities');
  }
};
