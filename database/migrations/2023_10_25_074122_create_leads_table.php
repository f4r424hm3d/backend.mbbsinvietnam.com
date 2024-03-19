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
    Schema::create('leads', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->string('email', 150);
      $table->string('mobile', 20);
      $table->text('message')->nullable();
      $table->unsignedBigInteger('service_id')->nullable();
      $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
      $table->enum('type', ['inquiry'])->default('inquiry');
      $table->string('source')->nullable();
      $table->text('source_path')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('leads');
  }
};
