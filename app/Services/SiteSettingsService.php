<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SiteSettingsService
{
    public function defaults(): array
    {
        $settings = config('wedding.settings');

        if (is_array($settings) && $settings !== []) {
            return $settings;
        }

        $config = require config_path('wedding.php');

        return is_array($config['settings'] ?? null) ? $config['settings'] : [];
    }

    public function all(): array
    {
        $defaults = $this->defaults();

        return array_merge($defaults, SiteSetting::getMany($defaults));
    }

    public function update(array $settings, array $bankAccounts, ?UploadedFile $shareImage, bool $useDefaultShareImage): void
    {
        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }

        $this->updateShareImage($shareImage, $useDefaultShareImage);
        BankAccount::syncFromInput($bankAccounts);
    }

    public function shareImageUrl(?string $storedPath = null): string
    {
        if (! empty($storedPath)) {
            if (str_starts_with($storedPath, 'images/')) {
                return asset($storedPath);
            }

            return asset('storage/'.$storedPath);
        }

        return asset(config('wedding.share_image.default_path', 'images/og-preview.jpg'));
    }

    private function updateShareImage(?UploadedFile $shareImage, bool $useDefaultShareImage): void
    {
        if ($shareImage) {
            $this->deleteShareImage(SiteSetting::get('share_image'));
            SiteSetting::set('share_image', $this->storeShareImage($shareImage));

            return;
        }

        if ($useDefaultShareImage) {
            $this->deleteShareImage(SiteSetting::get('share_image'));
            SiteSetting::set('share_image', '');
        }
    }

    private function storeShareImage(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = 'IMG-'.time().'.'.$extension;

        return $file->storeAs(
            config('wedding.share_image.directory', 'share'),
            $filename,
            config('wedding.share_image.disk', 'public'),
        );
    }

    private function deleteShareImage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $defaultFilename = basename(config('wedding.share_image.default_path', 'images/og-preview.jpg'));

        if (str_starts_with($path, 'images/')) {
            $filePath = public_path($path);

            if (is_file($filePath) && basename($filePath) !== $defaultFilename) {
                unlink($filePath);
            }

            return;
        }

        Storage::disk(config('wedding.share_image.disk', 'public'))->delete($path);
    }
}
