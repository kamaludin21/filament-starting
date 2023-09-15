<?php

use App\Models\ArticleCategory;
use App\Models\MainArticle;
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
    Schema::create('contributor_articles', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Stakeholder::class)
        ->constrained();
      $table->foreignIdFor(ArticleCategory::class)
        ->constrained();
      $table->foreignIdFor(MainArticle::class)
        ->nullable()
        ->constrained();
      $table->string('slug', 275);
      $table->string('title', 250);
      $table->longText('content', 5000);
      $table->string('thumbnail');
      $table->json('images')->nullable();
      $table->enum('edited_status', [
        'drafted',
        'completed',
        'published',
        'archived'
      ]);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('contributor_articles');
  }
};