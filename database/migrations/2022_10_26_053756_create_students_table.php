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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            // $table->boolean('sex');
            $table->string('student_phone_number')->nullable();
            $table->foreignId('teacher_classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('spp_master_id')->nullable()->constrained()->nullOnDelete();
            $table->Integer('personal_discount')->nullable()->default(0);
            $table->tinyInteger('join_month');
            $table->foreignId('school_year_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('students');
    }
};
