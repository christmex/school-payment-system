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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('petty_cash_code'); //SPP*tahun*bulan*tanggal*Auto increment id
            $table->string('petty_cash_title');//BAYAR SPP/DISCOUNT SPP/BAYAR DENDA/DISCOUNT DENDA jonathan tahun aaran bulan ksjdnak bla bla
            $table->enum('petty_cash_type',['IN','OUT']);
            $table->Integer('debit')->default(0);
            $table->Integer('credit')->default(0);
            $table->longText('description')->nullable();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('trx_date');
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
        Schema::dropIfExists('petty_cashes');
    }
};
