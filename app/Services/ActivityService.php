<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;

class ActivityService
{
    public function create(array $data): Activity
    {

        $data['status'] = 'draft';

        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {

        unset($data['status']);

        $activity->update($data);

        return $activity;
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw new DomainException(
                'Hanya activity dengan status draft yang dapat dipublikasikan.'
            );
        }

        $this->ensurePublishRequirements($activity);

        $activity->update([
            'status' => 'published',
        ]);

        return $activity;
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw new DomainException(
                'Hanya activity dengan status published yang dapat diselesaikan.'
            );
        }

        $activity->update([
            'status' => 'completed',
        ]);

        return $activity;
    }

    private function ensurePublishRequirements(Activity $activity): void
    {
        if (
            ! $activity->category_id ||
            ! $activity->code ||
            ! $activity->title ||
            ! $activity->location ||
            ! $activity->start_at ||
            ! $activity->end_at ||
            ! $activity->capacity
        ) {
            throw new DomainException(
                'Activity belum lengkap untuk dipublikasikan.'
            );
        }

        if ($activity->end_at < $activity->start_at) {
            throw new DomainException(
                'Waktu selesai harus sama atau setelah waktu mulai.'
            );
        }

        if ($activity->capacity < 1 || $activity->capacity > 500) {
            throw new DomainException(
                'Kapasitas harus berada antara 1 sampai 500.'
            );
        }
    }
}