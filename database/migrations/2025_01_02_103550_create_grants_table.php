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
        Schema::create('grants', function (Blueprint $table) {
            $table->id();
            $table->string('project_title');
            $table->text('project_description');
            $table->double('grant_amount');
            $table->string('grant_provider');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration');
            
            // Explicitly specify foreign key constraint
            $table->foreignId('leader_id')->constrained('academicians')->onDelete('cascade'); // Foreign key
            
            $table->timestamps();
            //$table->engine = 'InnoDB';  // Ensure using InnoDB engine
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grants');
    }
};

