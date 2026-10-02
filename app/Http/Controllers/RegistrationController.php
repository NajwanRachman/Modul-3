<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Activity;
use App\Services\RegistrationService;
use DomainException;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function store(
        StoreRegistrationRequest $request,
        Activity $activity,
        RegistrationService $service
    ): RedirectResponse {
        try {
            $service->register(
                $activity,
                $request->validated('participant_name'),
                $request->validated('email')
            );
        } catch (DomainException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'registration' => $e->getMessage(),
                ]);
        }

        return back()->with(
            'success',
            'Pendaftaran berhasil.'
        );
    }
}

