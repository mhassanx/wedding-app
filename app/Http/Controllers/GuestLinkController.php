<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GuestLinkController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Guest::create(['name' => $request->input('name')]);

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
