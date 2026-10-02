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
        $activity = $service->create($request->validated());

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil ditambahkan.');
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
        try {
            $service->update($activity, $request->validated());
        } catch (DomainException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'status' => $e->getMessage(),
                ]);
        }

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

   
}
