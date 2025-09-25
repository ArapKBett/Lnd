<?php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('loan_id')->constrained();
    $table->decimal('amount', 10, 2);
    $table->enum('method', ['mpesa', 'crypto']);
    $table->string('transaction_id');
    $table->timestamps();
});
