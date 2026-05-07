<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('password');
            $table->text('address')->nullable()->after('phone');
            $table->string('id_number')->nullable()->after('address');
            $table->decimal('credit_score', 5, 2)->default(0)->after('id_number');
            $table->decimal('savings_balance', 15, 2)->default(0)->after('credit_score');
            $table->decimal('loan_limit', 15, 2)->default(0)->after('savings_balance');
            $table->string('id_document')->nullable()->after('loan_limit');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'id_number',
                'credit_score',
                'savings_balance',
                'loan_limit',
                'id_document'
            ]);
        });
    }
};
