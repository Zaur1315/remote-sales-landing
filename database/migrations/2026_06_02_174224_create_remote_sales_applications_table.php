<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('remote_sales_applications', static function (Blueprint $table): void {
            $table->id();

            $table->string('telegram_username', 100);
            $table->string('english_level', 20);
            $table->text('sales_experience');

            $table->boolean('is_favorite')->default(false);
            $table->timestamp('viewed_at')->nullable();

            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index('is_favorite');
            $table->index('viewed_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remote_sales_applications');
    }
};
