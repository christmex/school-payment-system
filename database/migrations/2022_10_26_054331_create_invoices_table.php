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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            // $table->foreignId('teacher_classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_year_id')->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('payment_for_month');
            $table->Integer('amount');
            $table->Integer('fine_amount');
            $table->Integer('personal_discount');
            $table->Integer('fine_discount');
            $table->date('fine_date')->nullable()->default(NULL);
            $table->date('paid_date')->nullable()->default(NULL);
            $table->foreignId('payment_way_id')->nullable()->constrained()->nullOnDelete()->default(NULL);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
