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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('trainer_pembimbing')->nullable()->constrained('pembimbings')->onDelete('cascade');
            $table->foreignId('trainer_peserta')->nullable()->constrained('pembimbings')->onDelete('cascade');
            $table->date('date');
            $table->string('judul');
            $table->text('isi');
            $table->string('image')->nullable();
            $table->enum('peserta_approve',['0','1'])->default('0');
            $table->enum('pembimbing_approve',['0','1'])->default('0');
            $table->enum('status',['0','1','2','3'])->default('2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
