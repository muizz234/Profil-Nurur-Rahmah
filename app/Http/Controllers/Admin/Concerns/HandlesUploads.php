<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\ContentSupport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

trait HandlesUploads
{
    /**
     * Store an uploaded image on the public disk.
     * SVG (and any non jpg/jpeg/png/webp) is rejected even if validation was bypassed.
     */
    protected function storeImage(UploadedFile $file, string $folder): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = strtolower($file->getMimeType() ?? '');

        $allowedMimes = [
            'jpg' => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
            'png' => ['image/png'],
            'webp' => ['image/webp'],
        ];

        if (! array_key_exists($extension, $allowedMimes) || ! in_array($mime, $allowedMimes[$extension], true)) {
            throw ValidationException::withMessages([
                'image' => 'Format gambar tidak didukung. Gunakan jpg, jpeg, png, atau webp.',
            ]);
        }

        if ($file->getSize() > ContentSupport::MAX_IMAGE_KB * 1024) {
            throw ValidationException::withMessages([
                'image' => 'Ukuran gambar melebihi 2MB.',
            ]);
        }

        return $file->store($folder, 'public');
    }

    /**
     * Delete an image from the public disk when it exists.
     */
    protected function deleteImage(?string $path): void
    {
        if (filled($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
