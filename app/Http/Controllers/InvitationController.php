<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\GalleryImage;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Services\SiteSettingsService;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct(
        private readonly SiteSettingsService $siteSettings,
    ) {}

    public function show(): View
    {
        return $this->renderInvitation(null);
    }

    public function showForGuest(string $code): View
    {
        $guest = Guest::where('invite_code', $code)->firstOrFail();
        $guest->markAsOpened();

        return $this->renderInvitation($guest);
    }

    private function renderInvitation(?Guest $guest): View
    {
        $settings = $this->siteSettings->all();
        $shareImage = $this->siteSettings->shareImageUrl($settings['share_image'] ?? null);
        $brideName = $settings['bride_name'] ?? '';
        $groomName = $settings['groom_name'] ?? '';

        return view('invitation', [
            'rsvpCount' => Rsvp::count(),
            'guest' => $guest,
            'settings' => $settings,
            'galleryImages' => GalleryImage::ordered()->get(),
            'bankAccounts' => BankAccount::ordered()->get(),
            'pageTitle' => "{$brideName} & {$groomName} — Wedding Invitation",
            'pageDescription' => "Join us in celebrating the wedding of {$brideName} and {$groomName}.",
            'shareUrl' => url()->current(),
            'shareImage' => $shareImage,
        ]);
    }
}
