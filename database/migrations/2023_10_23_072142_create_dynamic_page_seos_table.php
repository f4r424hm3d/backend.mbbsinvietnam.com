<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dynamic_page_seos', function (Blueprint $table) {
      $table->id();
      $table->string('url', 100);
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
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('dynamic_page_seos');
  }
};
