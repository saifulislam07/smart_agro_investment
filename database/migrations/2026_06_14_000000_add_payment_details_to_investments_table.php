<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('investments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('amount');
            $table->string('payment_account_number')->nullable()->after('payment_method');
            $table->string('payment_bank_name')->nullable()->after('payment_account_number');
            $table->string('payment_reference')->nullable()->after('payment_bank_name');
            $table->date('payment_date')->nullable()->after('payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_account_number',
                'payment_bank_name',
                'payment_reference',
                'payment_date',
            ]);
        });
    }
};
