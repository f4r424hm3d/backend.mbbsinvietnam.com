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
    Schema::create('dynamic_page_faqs', function (Blueprint $table) {
      $table->id();
      $table->text('question');
      $table->longText('answer');
      $table->boolean('status')->default(1);
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
    Schema::dropIfExists('dynamic_page_faqs');
  }
};
