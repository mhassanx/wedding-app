<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRsvpRequest;
use App\Models\Guest;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function store(StoreRsvpRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $guest = null;
        if (!empty($data['invite_code'])) {
            $guest = Guest::where('invite_code', $data['invite_code'])->first();
        }

        Rsvp::create([
            'guest_id' => $guest?->id,
            'name' => $data['name'],
            'guest_count' => $data['guest_count'],
            'message' => $data['message'] ?? null,
        ]);

        $redirectRoute = $guest
            ? redirect()->route('invite.show', ['code' => $guest->invite_code])
            : redirect()->route('home');

        return $redirectRoute
            ->with('rsvp_success', true)
            ->withFragment('rsvp');
    }

    public function index(): View
    {
        $rsvps = Rsvp::with('guest')->orderByDesc('created_at')->get();

        return view('rsvps.index', [
            'rsvps' => $rsvps,
            'totalGuests' => $rsvps->sum('guest_count'),
        ]);
    }
}
