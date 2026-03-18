<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('services', function (Blueprint $table) {
      $table->string('icon_class', 100)->default('bi bi-stars')->after('title');
    });

    DB::table('services')->where('title', 'Web Development')->update(['icon_class' => 'bi bi-code-slash']);
    DB::table('services')->where('title', 'Mobile App Development')->update(['icon_class' => 'bi bi-phone']);
    DB::table('services')->where('title', 'UI/UX Design')->update(['icon_class' => 'bi bi-palette']);
    DB::table('services')->where('title', 'Graphic Design')->update(['icon_class' => 'bi bi-brush']);
    DB::table('services')->where('title', 'Cloud Solutions')->update(['icon_class' => 'bi bi-cloud']);
    DB::table('services')->where('title', 'Digital Marketing')->update(['icon_class' => 'bi bi-megaphone']);
  }

  public function down(): void
  {
    Schema::table('services', function (Blueprint $table) {
      $table->dropColumn('icon_class');
    });
  }
};
