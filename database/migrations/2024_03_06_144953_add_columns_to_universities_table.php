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
    Schema::table('universities', function (Blueprint $table) {
      $table->longText('top_description')->after('institute_type')->nullable();
      $table->longText('bottom_description')->after('top_description')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('universities', function (Blueprint $table) {
      //
    });
  }
};
