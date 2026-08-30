<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'current_team_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreignId('current_team_id')->nullable();
                });
            }
            if (!Schema::hasColumn('users', 'credits')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->integer('credits')->default(100);
                });
            }
            if (!Schema::hasColumn('users', 'ai_preferences')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->json('ai_preferences')->nullable();
                });
            }
        }

        if (!Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->boolean('personal_team')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('team_user')) {
            Schema::create('team_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('team_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('role')->nullable();
                $table->timestamps();
                $table->unique(['team_id', 'user_id']);
            });
        }

        if (Schema::hasTable('posts') && !Schema::hasColumn('posts', 'team_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreignId('team_id')->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'team_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('team_id');
            });
        }
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('teams');
    }
};
