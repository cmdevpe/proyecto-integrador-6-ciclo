<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('one_time_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('purpose')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code_hash');
            $table->string('channel')->default('mail')->index();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->unsignedTinyInteger('max_attempts')->default(5);
            $table->timestamp('consumed_at')->nullable()->index();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->index(['user_id', 'purpose', 'consumed_at', 'expires_at'], 'otp_user_purpose_active_idx');
            $table->index(['user_id', 'purpose', 'created_at'], 'otp_user_purpose_created_idx');
            $table->index(['consumed_at', 'expires_at'], 'otp_consumed_expires_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_time_passwords');
    }
};
