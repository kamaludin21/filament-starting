<?php

use App\Models\Institute;
use App\Models\User;
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
    Schema::create('stakeholders', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Institute::class)
        ->constrained();
      $table->foreignIdFor(User::class)
        ->constrained();
      $table->boolean('is_active')->default(false);
      $table->enum('level', ['superadmin', 'admin', 'contributor', 'undefined'])
        ->default('undefined');
      $table->string('position')->nullable();
      $table->string('photo')->nullable();
      $table->string('description', 300)->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('stakeholders');
  }
};
