<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class ImageHelper
{
    static function storeImageWithDifferentSizes($imageFile, $prefix, $location)
    {
        $app_prefix = env('APP_PREFIX');
        $image = $imageFile;

        $hashName = md5(time());

        $extension = $image->getClientOriginalExtension();
        $fileName  = "$prefix-$hashName.$extension";

        // Large File
        $largeFilePath = storage_path("$location/lg");

        $largeImg = Image::make($image->getRealPath());
        $largeImg->resize(500, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save($largeFilePath . '/' . $fileName);

        // Medium File
        $mediumFilePath = storage_path("$location/md");

        $mediumImg = Image::make($image->getRealPath());
        $mediumImg->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($mediumFilePath . '/' . $fileName);

        // Small File
        $smallFilePath = storage_path("$location/sm");

        $smallImg = Image::make($image->getRealPath());
        $smallImg->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save($smallFilePath . '/' . $fileName);

        return $fileName;
    }

    static function deleteImageWithDifferentSizes($fileName, $location)
    {
        return true;
    }

    static function storeImageWithFixedSize($imageFile, $prefix, $location)
    {
        $app_prefix = env('APP_PREFIX');
        $image = $imageFile;

        $hashName = md5(time());

        $extension = $image->getClientOriginalExtension();
        $fileName  = "$prefix-$hashName.$extension";

        // Large File
        $filePath = storage_path("$location");

        $storedImage = Image::make($image->getRealPath());
        $storedImage->resize(500, 400, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath . '/' . $fileName);

        return $fileName;
    }

    static function deleteImageWithFixedSize($fileName, $location)
    {
        return true;
    }
}