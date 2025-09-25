<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users');
            $table->decimal('amount', 10, 2);
            $table->integer('term_months');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('limit_boost', 10, 2)->default(0);  // From savings
            $table->enum('status', ['pending', 'approved', 'rejected', 'repaid'])->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('loans'); }
};
