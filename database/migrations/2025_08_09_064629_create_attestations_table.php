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
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('transaction_number');
            $table->string('payment_id');
            $table->decimal('total_payment', 8, 2);
            $table->date('transaction_date');
            $table->string('document_type');
            $table->string('applicant_name');
            $table->string('email');
            $table->string('phone');
            $table->string('verifier_name');
            $table->string('verification_status');
            $table->dateTime('verification_datetime');
            $table->string('approver_name')->nullable();
            $table->string('original_document_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attestations');
    }
};
