<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\GalleryImage;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Models\SiteSetting;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(): View
    {
        return $this->renderInvitation(null);
    }

    public function showForGuest(string $code): View
    {
        $guest = Guest::where('invite_code', $code)->firstOrFail();

        if (!$guest->opened_at) {
            $guest->update(['opened_at' => now()]);
        }

        return $this->renderInvitation($guest);
    }

    private function renderInvitation(?Guest $guest): View
    {
        $galleryImages = GalleryImage::orderBy('sort_order')->get();

        $settings = SiteSetting::getMany([
            'bride_name' => 'Ayesha Tariq',
            'groom_name' => 'Adnan Ashraf',
            'share_image' => '',
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
        ]);

        $shareImage = $this->resolveShareImageUrl($settings, $galleryImages);
        $pageTitle = "{$settings['bride_name']} & {$settings['groom_name']} — Wedding Invitation";
        $pageDescription = "Join us in celebrating the wedding of {$settings['bride_name']} and {$settings['groom_name']}.";

        return view('invitation', [
            'rsvpCount' => Rsvp::count(),
            'guest' => $guest,
            'settings' => $settings,
            'galleryImages' => $galleryImages,
            'bankAccounts' => BankAccount::ordered()->get(),
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'shareUrl' => url()->current(),
            'shareImage' => $shareImage,
        ]);
    }

    private function resolveShareImageUrl(array $settings, $galleryImages): ?string
    {
        if (! empty($settings['share_image'])) {
            return asset('storage/'.$settings['share_image']);
        }

        $firstImage = $galleryImages->first();

        if ($firstImage) {
            return asset('storage/'.$firstImage->path);
        }

        return null;
    }
}
