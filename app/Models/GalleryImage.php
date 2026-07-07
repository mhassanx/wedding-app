<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'path',
        'caption',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public static function storeUploads(array $files): void
    {
        $sortOrder = static::max('sort_order') ?? 0;
        $disk = config('wedding.gallery.disk', 'public');
        $directory = config('wedding.gallery.directory', 'gallery');

        foreach ($files as $image) {
            /** @var UploadedFile $image */
            $extension = $image->getClientOriginalExtension() ?: 'jpg';
            $filename = 'IMG-'.time().'-'.($sortOrder + 1).'.'.$extension;
            $path = $image->storeAs($directory, $filename, $disk);

            static::create([
                'path' => $path,
                'caption' => null,
                'sort_order' => ++$sortOrder,
            ]);
        }
    }

    public function deleteWithFile(): void
    {
        Storage::disk(config('wedding.gallery.disk', 'public'))->delete($this->path);
        $this->delete();
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
