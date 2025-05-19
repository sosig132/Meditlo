<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    DB::statement("ALTER TABLE content MODIFY source ENUM('youtube', 'cloud', 'local') NOT NULL");
    DB::statement("ALTER TABLE content MODIFY description TEXT NULL");
  }

  public function down(): void
  {
    DB::statement("ALTER TABLE content MODIFY source ENUM('youtube', 'cloud', 'local') NULL");
    DB::statement("ALTER TABLE content MODIFY description TEXT NOT NULL");
  }
};
