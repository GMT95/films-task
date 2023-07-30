<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    public static function saveImage(UploadedFile $uploadedFile, string $disk = 'public', string $folder = 'posters'): string
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;

        $path = Storage::disk($disk)->putFileAs("/$folder", $uploadedFile, $fileName);

        return $path;
    }
}
