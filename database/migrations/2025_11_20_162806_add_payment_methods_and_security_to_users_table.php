<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Payment Methods
            $table->string('mpesa_number')->nullable()->after('phone');
            $table->string('crypto_address')->nullable()->after('mpesa_number');
            $table->enum('preferred_payment_method', ['mpesa', 'crypto'])->default('mpesa')->after('crypto_address');
            
            // Security & Tracking
            $table->string('last_login_ip')->nullable()->after('loan_limit');
            $table->timestamp('last_login_at')->nullable()->after('last_login_ip');
            $table->string('device_info')->nullable()->after('last_login_at');
            $table->boolean('is_active')->default(true)->after('device_info');
            $table->timestamp('email_verified_at')->nullable()->change();
        });

        // Create user sessions table for security tracking
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('device_type');
            $table->string('browser');
            $table->string('platform');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('login_at');
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('logout_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create loan payments table
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('remaining_balance', 15, 2);
            $table->date('payment_date')->nullable();
            $table->date('due_date');
            $table->enum('status', ['pending', 'completed', 'overdue'])->default('pending');
            $table->enum('method', ['mpesa', 'crypto', 'bank'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Add more fields to loans table
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('remaining_balance', 15, 2)->default(0)->after('amount');
            $table->date('disbursement_date')->nullable()->after('remaining_balance');
            $table->date('next_payment_date')->nullable()->after('disbursement_date');
            $table->date('final_due_date')->nullable()->after('next_payment_date');
            $table->enum('disbursement_method', ['mpesa', 'crypto'])->nullable()->after('final_due_date');
            $table->string('disbursement_reference')->nullable()->after('disbursement_method');
            $table->decimal('monthly_payment', 15, 2)->nullable()->after('disbursement_reference');
            $table->integer('payments_made')->default(0)->after('monthly_payment');
            $table->integer('payments_total')->default(0)->after('payments_made');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mpesa_number',
                'crypto_address',
                'preferred_payment_method',
                'last_login_ip',
                'last_login_at',
                'device_info',
                'is_active'
            ]);
        });

        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('loan_payments');

        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'remaining_balance',
                'disbursement_date',
                'next_payment_date',
                'final_due_date',
                'disbursement_method',
                'disbursement_reference',
                'monthly_payment',
                'payments_made',
                'payments_total'
            ]);
        });
    }
};
