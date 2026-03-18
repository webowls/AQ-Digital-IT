<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('user_type', 50)->default('customer')->after('is_admin');
      $table->string('account_status', 20)->default('active')->after('user_type');
    });

    DB::table('users')->where('is_admin', true)->update([
      'user_type' => 'superadmin',
      'account_status' => 'active',
    ]);
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['user_type', 'account_status']);
    });
  }
};
