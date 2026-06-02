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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('business_type');
            $table->string('status');
            $table->string('investment_time');
            $table->string('duration');
            $table->date('start_date');
            $table->date('mature_date');
            $table->decimal('goal', 14, 2);
            $table->decimal('minimum_investment', 14, 2);
            $table->decimal('raised', 14, 2);
            $table->string('roi');
            $table->string('image');
            $table->json('gallery')->nullable();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->text('market_opportunity')->nullable();
            $table->text('risk_factors')->nullable();
            $table->boolean('is_live')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
