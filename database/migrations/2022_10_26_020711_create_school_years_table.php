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
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('school_year_name')->unique();
            $table->smallInteger('school_year_start')->unique();
            // $table->tinyInteger('school_year_month_start')->default(7);
            $table->smallInteger('school_year_end')->unique();
            // $table->tinyInteger('school_year_month_end')->default(6);
            $table->tinyInteger('date_of_fine')->nullable();
            $table->smallInteger('fine_amount')->nullable();
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('school_years');
    }
};
