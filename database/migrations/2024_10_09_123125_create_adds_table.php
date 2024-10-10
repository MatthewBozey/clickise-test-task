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
        Schema::create('adds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->enum('status', ['Активен', 'В ожидании', 'В архиве'])->default('В ожидании');
            $table->string('url');
            $table->integer('impressions_count')->default(0);
            $table->decimal('crm', 8, 2)->default(0.00);
            $table->decimal('budget', 10, 2)->default(0.00);
            $table->enum('button_text', ['Смотреть', 'Оставить заявку', 'Скачать', 'Подробнее'])->default('Смотреть');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adds');
    }
};
