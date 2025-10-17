<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 100);
            $table->string('description', 500);
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->date('delivery_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['client_name', 'delivery_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
