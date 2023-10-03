<?php

use App\Models\ArticleCategory;
use App\Models\Stakeholder;
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
    Schema::create('main_articles', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Stakeholder::class)
        ->constrained();
      $table->foreignIdFor(ArticleCategory::class)
        ->constrained();
      $table->string('title', 250);
      $table->string('slug')->unique();
      $table->text('content', 5000);
      $table->string('thumbnail');
      $table->string('thumbnail_alt', 100);
      $table->json('images')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('main_articles');
  }
};
