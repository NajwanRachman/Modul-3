<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('code', 30)->nullable()->after('category_id');
            $table->dateTime('start_at')->nullable()->after('activity_date');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->string('location', 150)->nullable()->after('end_at');
            $table->unsignedInteger('capacity')->nullable()->after('location');
        });

        // Mengisi code untuk data lama agar setiap activity memiliki code unik.
        $activities = DB::table('activities')
            ->select('id')
            ->orderBy('id')
            ->get();

        foreach ($activities as $activity) {
            DB::table('activities')
                ->where('id', $activity->id)
                ->update([
                    'code' => 'ACT-' . str_pad($activity->id, 4, '0', STR_PAD_LEFT),
                ]);
        }

        // Mengisi data awal untuk field baru pada data lama.
        DB::statement("
            UPDATE activities
            SET
                start_at = activity_date || ' 09:00:00',
                end_at = activity_date || ' 11:00:00',
                location = 'Belum ditentukan',
                capacity = 50
            WHERE start_at IS NULL
               OR end_at IS NULL
               OR location IS NULL
               OR capacity IS NULL
        ");

        // Menyesuaikan status lama dengan state pada Special Challenge.
        DB::table('activities')
            ->where('status', 'Planned')
            ->update(['status' => 'draft']);

        DB::table('activities')
            ->where('status', 'Ongoing')
            ->update(['status' => 'published']);

        DB::table('activities')
            ->where('status', 'Done')
            ->update(['status' => 'completed']);

        // Code harus unik.
        Schema::table('activities', function (Blueprint $table) {
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn([
                'code',
                'start_at',
                'end_at',
                'location',
                'capacity',
            ]);
        });

        // Mengembalikan status ke format sebelumnya.
        DB::table('activities')
            ->where('status', 'draft')
            ->update(['status' => 'Planned']);

        DB::table('activities')
            ->where('status', 'published')
            ->update(['status' => 'Ongoing']);

        DB::table('activities')
            ->where('status', 'completed')
            ->update(['status' => 'Done']);
    }
};