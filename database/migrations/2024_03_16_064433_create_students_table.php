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
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->string('email', 100);
      $table->integer('c_code');
      $table->integer('mobile');
      $table->string('password', 100)->nullable();
      $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
      $table->date('dob')->nullable();
      $table->string('nationality', 60)->nullable();
      $table->string('first_language', 50)->nullable();
      $table->string('marital_status', 100)->nullable();
      $table->bigInteger('passport_number')->nullable();
      $table->date('passport_expiry')->nullable();
      $table->text('home_address')->nullable();
      $table->bigInteger('home_contact_number')->nullable();
      $table->string('city', 100)->nullable();
      $table->string('state', 100)->nullable();
      $table->string('country', 100)->nullable();
      $table->bigInteger('zip_code')->nullable();
      $table->string('father', 100)->nullable();
      $table->string('father_mobile', 100)->nullable();
      $table->string('mother', 100)->nullable();
      $table->string('mother_mobile', 100)->nullable();
      $table->string('grading_scheme', 100)->nullable();
      $table->string('grade_average', 100)->nullable();
      $table->string('english_exam_type', 100)->nullable();
      $table->string('date_of_exam', 100)->nullable();
      $table->string('listening_score', 100)->nullable();
      $table->string('reading_score', 100)->nullable();
      $table->string('writing_score', 100)->nullable();
      $table->string('speaking_score', 100)->nullable();
      $table->string('overall_score', 100)->nullable();
      $table->string('gre', 100)->nullable();
      $table->string('gre_exam_date', 100)->nullable();
      $table->string('gre_v_score', 100)->nullable();
      $table->string('gre_v_rank', 100)->nullable();
      $table->string('gre_q_score', 100)->nullable();
      $table->string('gre_q_rank', 100)->nullable();
      $table->string('gre_w_score', 100)->nullable();
      $table->string('gre_w_rank', 100)->nullable();
      $table->string('gmat', 100)->nullable();
      $table->string('gmat_exam_date', 100)->nullable();
      $table->string('gmat_v_score', 100)->nullable();
      $table->string('gmat_v_rank', 100)->nullable();
      $table->string('gmat_q_score', 100)->nullable();
      $table->string('gmat_q_rank', 100)->nullable();
      $table->string('gmat_w_score', 100)->nullable();
      $table->string('gmat_w_rank', 100)->nullable();
      $table->string('gmat_ir_score', 100)->nullable();
      $table->string('gmat_ir_rank', 100)->nullable();
      $table->string('gmat_total_score', 100)->nullable();
      $table->string('gmat_total_rank', 100)->nullable();
      $table->string('sat', 100)->nullable();
      $table->string('sat_exam_date', 100)->nullable();
      $table->string('sat_reasoning_point', 100)->nullable();
      $table->string('sat_subject_point', 100)->nullable();
      $table->string('refused_visa', 100)->nullable();
      $table->string('valid_study_permit', 100)->nullable();
      $table->string('country_of_education', 100)->nullable();
      $table->bigInteger('highest_level_of_education')->nullable();
      $table->string('current_qualification_level', 100)->nullable();
      $table->string('intrested_program', 100)->nullable();
      $table->string('intrested_course_category', 100)->nullable();
      $table->string('intrested_university', 100)->nullable();
      $table->string('source', 100)->nullable();
      $table->string('preferred_destination', 100)->nullable();
      $table->boolean('status')->default(1);
      $table->bigInteger('login_count')->default(0);
      $table->string('last_login', 100)->nullable();
      $table->string('lead_type')->default('new');
      $table->boolean('whatsapped')->default(0);
      $table->boolean('called')->default(0);
      $table->boolean('enrolled')->default(0);
      $table->string('lead_status')->default('Fresh');
      $table->string('lead_sub_status')->default('Fresh');
      $table->integer('otp')->nullable();
      $table->string('otp_expire_at', 100)->nullable();
      $table->boolean('email_verified')->default(0);
      $table->timestamp('email_verified_at')->nullable();
      $table->string('remember_token', 100)->nullable();
      $table->text('visa_note')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('students');
  }
};
