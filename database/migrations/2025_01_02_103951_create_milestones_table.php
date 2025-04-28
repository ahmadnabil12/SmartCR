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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grant_id')->constrained()->onDelete('cascade');
            $table->string('milestone_title');
            $table->date('completion_date');
            $table->string('deliverable');
            $table->string('status');
            $table->string('remark')->nullable();
            //$table->date('date_updated');
            $table->timestamps();
            //$table->engine = 'InnoDB';  // Ensure using InnoDB engine
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
