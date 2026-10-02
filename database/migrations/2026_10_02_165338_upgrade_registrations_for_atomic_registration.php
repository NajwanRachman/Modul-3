<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('participant_name')->nullable()->after('activity_id');
            $table->string('email')->nullable()->after('participant_name');
            $table->timestamp('registered_at')->nullable()->after('email');
        });

        DB::table('registrations')->update([
            'participant_name' => 'Peserta Lama',
            'email' => 'peserta.lama@example.com',
            'registered_at' => DB::raw('created_at'),
        ]);

        Schema::table('registrations', function (Blueprint $table) {
            $table->unique(['activity_id', 'email']);
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedInteger('registered_count')
                ->default(0)
                ->after('capacity');
        });

        DB::statement('
            UPDATE activities
            SET registered_count = (
                SELECT COUNT(*)
                FROM registrations
                WHERE registrations.activity_id = activities.id
            )
        ');
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('registered_count');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['activity_id', 'email']);

            $table->dropColumn([
                'participant_name',
                'email',
                'registered_at',
            ]);
        });
    }
};