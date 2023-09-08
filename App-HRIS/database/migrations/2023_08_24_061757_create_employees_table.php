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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('branch');
            $table->string('organization');
            $table->string('job_position');
            $table->string('job_level');
            $table->string('employment_status');
            $table->date('join_date');
            $table->date('resign_date')->nullable();
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address');
            $table->string('mobile_phone');
            $table->string('religion');
            $table->string('gender');
            $table->string('marital_status');
            $table->decimal('salary', 10, 2);
            $table->decimal('tunjangan', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
