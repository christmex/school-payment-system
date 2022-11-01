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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_invoice');
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('spp_master_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_year_id')->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('payment_for_month');
            $table->Integer('fine_amount')->nullable()->default(0);
            $table->integer('discount_fine')->nullable()->default(0);
            $table->Integer('total_amount')->nullable()->default(0);
            $table->integer('discount_personal')->nullable()->default(0);
            $table->Integer('paid_amount')->nullable()->default(0);
            $table->longText('description')->nullable();
            $table->foreignId('payment_way_id')->nullable()->constrained()->nullOnDelete()->default(NULL);
            $table->date('payment_date')->nullable()->default(NULL);
            $table->boolean('is_paid')->nullable()->default(false);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('payments');
    }
};
