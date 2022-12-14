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
            $table->foreignId('invoice_group_id')->nullable()->constrained()->nullOnDelete()->default(NULL);
            $table->string('invoice_number');
            // $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            // $table->foreignId('teacher_classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_year_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->Integer('payment_for_month');
            $table->Integer('amount');
            $table->Integer('fine_amount')->default(0);
            $table->Integer('personal_discount')->default(0);
            $table->Integer('fine_discount')->default(0);
            $table->date('due_date')->nullable()->default(NULL);
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
