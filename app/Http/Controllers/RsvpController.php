<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRsvpRequest;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function store(StoreRsvpRequest $request): RedirectResponse
    {
        $rsvp = Rsvp::createFromRequest($request->validated());

        $redirectRoute = $rsvp->guest
            ? redirect()->route('invite.show', ['code' => $rsvp->guest->invite_code])
            : redirect()->route('home');

        return $redirectRoute
            ->with('rsvp_success', true)
            ->withFragment('rsvp');
    }

    public function index(): View
    {
        $rsvps = Rsvp::latest()->with('guest')->get();

        return view('rsvps.index', [
            'rsvps' => $rsvps,
            'totalGuests' => $rsvps->sum('guest_count'),
        ]);
    }
}
