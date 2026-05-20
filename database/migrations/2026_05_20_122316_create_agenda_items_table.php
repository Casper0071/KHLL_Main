<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['concept', 'published', 'cancelled'])->default('concept');
            $table->string('color')->default('#f97316'); // primary color als default
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // daily, weekly, monthly
            $table->json('additional_data')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Voor veilig verwijderen
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_items');
    }
};
