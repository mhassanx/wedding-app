<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Models\Guest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestLinkController extends Controller
{
    public function store(StoreGuestRequest $request): RedirectResponse
    {
        Guest::create(['name' => $request->validated('name')]);

        return redirect()
            ->route('admin.dashboard', ['key' => $request->query('key')])
            ->with('guest_added', true);
    }

    public function destroy(Guest $guest, Request $request): RedirectResponse
    {
        $guest->delete();

        return redirect()->route('admin.dashboard', ['key' => $request->query('key')]);
    }
}
