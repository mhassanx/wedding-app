<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\GalleryImage;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $rsvps = Rsvp::orderByDesc('created_at')->get();
        $guests = Guest::with('rsvp')->orderByDesc('created_at')->get();

        return view('admin.dashboard', [
            'rsvps' => $rsvps,
            'totalGuests' => $rsvps->sum('guest_count'),
            'guestLinks' => $guests,
            'key' => request()->query('key'),
        ]);
    }

    public function editSettings(): View
    {
        $settings = SiteSetting::getMany($this->defaultSettings());

        return view('admin.settings', [
            'settings' => $settings,
            'bankAccounts' => BankAccount::ordered()->get(),
            'key' => request()->query('key'),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:255'],
            'mehndi_date' => ['required', 'string', 'max:100'],
            'mehndi_time' => ['required', 'string', 'max:50'],
            'mehndi_venue' => ['required', 'string', 'max:255'],
            'nikah_date' => ['required', 'string', 'max:100'],
            'nikah_time' => ['required', 'string', 'max:50'],
            'nikah_venue' => ['required', 'string', 'max:255'],
            'walima_date' => ['required', 'string', 'max:100'],
            'walima_time' => ['required', 'string', 'max:50'],
            'walima_venue' => ['required', 'string', 'max:255'],
            'countdown_target' => ['required', 'string', 'max:50'],
            'contact_name_1' => ['nullable', 'string', 'max:255'],
            'contact_phone_1' => ['nullable', 'string', 'max:50'],
            'contact_name_2' => ['nullable', 'string', 'max:255'],
            'contact_phone_2' => ['nullable', 'string', 'max:50'],
            'bank_accounts' => ['nullable', 'array'],
            'bank_accounts.*.account_name' => ['required', 'string', 'max:255'],
            'bank_accounts.*.account_holder_name' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.account_number' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.iban' => ['nullable', 'string', 'max:255'],
            'bank_accounts.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'bank_accounts') {
                continue;
            }

            SiteSetting::set($key, $value);
        }

        if ($request->hasFile('share_image')) {
            $request->validate([
                'share_image' => ['image', 'max:5120'],
            ]);

            $existingImage = SiteSetting::get('share_image');

            if ($existingImage) {
                Storage::disk('public')->delete($existingImage);
            }

            $path = $request->file('share_image')->store('share', 'public');
            SiteSetting::set('share_image', $path);
        }

        BankAccount::query()->delete();

        foreach ($request->input('bank_accounts', []) as $index => $accountData) {
            $accountData = array_filter($accountData, function ($value) {
                return $value !== null && $value !== '';
            });

            if (empty($accountData)) {
                continue;
            }

            BankAccount::create([
                'account_name' => $accountData['account_name'] ?? '',
                'account_holder_name' => $accountData['account_holder_name'] ?? null,
                'account_number' => $accountData['account_number'] ?? '',
                'iban' => $accountData['iban'] ?? null,
                'sort_order' => $accountData['sort_order'] ?? $index,
            ]);
        }

        return redirect()
            ->route('admin.settings.edit', ['key' => $request->query('key')])
            ->with('settings_saved', true);
    }

    public function gallery(): View
    {
        return view('admin.gallery', [
            'images' => GalleryImage::orderBy('sort_order')->get(),
            'key' => request()->query('key'),
        ]);
    }

    public function uploadGalleryImage(Request $request): RedirectResponse
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $sortOrder = GalleryImage::max('sort_order') ?? 0;

        foreach ($request->file('images') as $image) {

            $path = $image->store('gallery', 'public');

            GalleryImage::create([
                'path' => $path,
                'caption' => null,
                'sort_order' => ++$sortOrder,
            ]);
        }

        return redirect()
            ->route('admin.gallery', ['key' => $request->query('key')])
            ->with('image_uploaded', true);
    }

    public function deleteGalleryImage(GalleryImage $image, Request $request): RedirectResponse
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.gallery', ['key' => $request->query('key')]);
    }

    private function defaultSettings(): array
    {
        return [
            'bride_name' => 'Ayesha Tariq',
            'groom_name' => 'Adnan Ashraf',
            'mehndi_date' => '23 July 2026',
            'mehndi_time' => '6:00 PM',
            'mehndi_venue' => 'Royal Garden Marriage Hall, Mian Channu',
            'nikah_date' => '24 July 2026',
            'nikah_time' => '6:00 PM',
            'nikah_venue' => 'Mughal E Azam Event Hall, Mian Channu',
            'walima_date' => '25 July 2026',
            'walima_time' => '6:00 PM',
            'walima_venue' => 'Mughal E Azam Event Hall, Mian Channu',
            'countdown_target' => '2026-07-23T18:00:00+05:00',
            'contact_name_1' => '',
            'contact_phone_1' => '',
            'contact_name_2' => '',
            'contact_phone_2' => '',
            'gift_bank_details' => '',
            'share_image' => '',
        ];
    }
}
