<?php

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
    Schema::create('publisheds', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Stakeholder::class)->constrained();
      $table->foreignIdFor(MainArticle::class)
        ->constrained()
        ->cascadeOnDelete();
      $table->enum('publish_status', [
        'queue',
        'preview',
        'hold',
        'publish'
      ])->default('queue');
      $table->timestamp('publish_date')->nullable();
      $table->enum('edited_status', [
        'drafted',
        'completed',
        'archived'
      ]);
      $table->json('edited_history');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('publisheds');
  }
};
