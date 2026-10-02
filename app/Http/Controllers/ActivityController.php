<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request): View
{
    $search = $request->query('search');
    $categoryId = $request->query('category_id');
    $status = $request->query('status');
    $sort = $request->query('sort', 'newest');

    $activities = Activity::query()
        ->with('category')
        ->when(
            $search,
            fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            })
        )
        ->when(
            $categoryId,
            fn ($query) => $query->where('category_id', $categoryId)
        )
        ->when(
            in_array($status, Activity::STATUSES, true),
            fn ($query) => $query->where('status', $status)
        )
        ->when(
            $sort === 'oldest',
            fn ($query) => $query->orderBy('start_at', 'asc')
        )
        ->when(
            $sort !== 'oldest',
            fn ($query) => $query->orderBy('start_at', 'desc')
        )
        ->paginate(10)
        ->withQueryString();

    $categories = \App\Models\Category::orderBy('name')->get();

    return view('activities.index', compact(
        'activities',
        'categories',
        'search',
        'categoryId',
        'status',
        'sort'
    ));
}

    public function create(): View
    {
        return view('activities.create');
    }

    public function store(
    StoreActivityRequest $request,
    ActivityService $service
): RedirectResponse {
    $data = $request->validated();

    $poster = $request->file('poster');
    unset($data['poster']);

    $activity = $service->create($data);

    if ($poster) {
        $path = $poster->store('posters', 'public');

        $activity->update([
            'poster_path' => $path,
        ]);
    }

    return redirect()
        ->route('activities.index')
        ->with('success', 'Kegiatan berhasil dibuat.');
}

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
    }

   public function update(
    UpdateActivityRequest $request,
    Activity $activity,
    ActivityService $service
): RedirectResponse {
    $data = $request->validated();

    $poster = $request->file('poster');
    unset($data['poster']);

    $oldPosterPath = $activity->poster_path;

    $service->update($activity, $data);

    if ($poster) {
        $newPosterPath = $poster->store('posters', 'public');

        $activity->update([
            'poster_path' => $newPosterPath,
        ]);

        if ($oldPosterPath) {
            Storage::disk('public')->delete($oldPosterPath);
        }
    }

    return redirect()
        ->route('activities.show', $activity)
        ->with('success', 'Kegiatan berhasil diperbarui.');
}

        public function publish(
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->publish($activity);
        } catch (DomainException $e) {
            return back()
                ->withErrors([
                    'status' => $e->getMessage(),
                ]);
        }

        return back()->with(
            'success',
            'Kegiatan berhasil dipublikasikan.'
        );
    }

    public function complete(
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->complete($activity);
        } catch (DomainException $e) {
            return back()
                ->withErrors([
                    'status' => $e->getMessage(),
                ]);
        }

        return back()->with(
            'success',
            'Kegiatan berhasil diselesaikan.'
        );
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

        public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->get();

        return view('activities.trash', compact('activities'));
    }

    public function restore(int $id): RedirectResponse
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);

        $activity->restore();

        return redirect()
            ->route('activities.trash')
            ->with('success', 'Kegiatan berhasil dipulihkan.');
    }

   
}
