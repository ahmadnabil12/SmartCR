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
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('unit');
            $table->date('need_by_date');
            $table->string('status')->default('Requirement Gathering');
            $table->string('complexity')->nullable(); // Low, Medium, High
            $table->text('comment')->nullable();
            $table->foreignId('requestor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('implementor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};
