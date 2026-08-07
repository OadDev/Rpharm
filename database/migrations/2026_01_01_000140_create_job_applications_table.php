<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('position');
            $table->text('cover_note')->nullable();
            $table->string('cv_path');
            $table->string('cv_original_name')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
