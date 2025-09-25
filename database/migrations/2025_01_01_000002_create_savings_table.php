<?php
// Similar structure
Schema::create('savings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_id')->constrained('users');
    $table->decimal('balance', 10, 2)->default(0);
    $table->timestamps();
});
