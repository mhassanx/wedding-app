<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\GalleryImage;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Http\Requests\UpdateSiteSettingsRequest;
use App\Http\Requests\UploadGalleryImagesRequest;
use App\Services\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct(
        private readonly SiteSettingsService $siteSettings,
    ) {}

    public function dashboard(): View
    {
        $rsvps = Rsvp::latest()->get();

        return view('admin.dashboard', [
            'rsvps' => $rsvps,
            'totalGuests' => $rsvps->sum('guest_count'),
            'guestLinks' => Guest::latest()->with('rsvp')->get(),
            'key' => request()->query('key'),
        ]);
    }

    public function editSettings(): View
    {
        return view('admin.settings', [
            'settings' => $this->siteSettings->all(),
            'bankAccounts' => BankAccount::ordered()->get(),
            'key' => request()->query('key'),
        ]);
    }

    public function updateSettings(UpdateSiteSettingsRequest $request): RedirectResponse
    {
        $this->siteSettings->update(
            settings: $request->settingAttributes(),
            bankAccounts: $request->bankAccounts(),
            shareImage: $request->file('share_image'),
            useDefaultShareImage: $request->shouldUseDefaultShareImage(),
        );

        return redirect()
            ->route('admin.settings.edit', ['key' => $request->query('key')])
            ->with('settings_saved', true);
    }

    public function gallery(): View
    {
        return view('admin.gallery', [
            'images' => GalleryImage::ordered()->get(),
            'key' => request()->query('key'),
        ]);
    }

    public function uploadGalleryImage(UploadGalleryImagesRequest $request): RedirectResponse
    {
        GalleryImage::storeUploads($request->file('images'));

        return redirect()
            ->route('admin.gallery', ['key' => $request->query('key')])
            ->with('image_uploaded', true);
    }

    public function deleteGalleryImage(GalleryImage $image, Request $request): RedirectResponse
    {
        $image->deleteWithFile();

        return redirect()->route('admin.gallery', ['key' => $request->query('key')]);
    }
}
