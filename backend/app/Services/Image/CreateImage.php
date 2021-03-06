<?php

namespace App\Services\Image;

use App\Models\Image;

class CreateImage
{
    public static function create($file, int $article_id)
    {
        $micro = explode(" ", microtime());
        $date = date("Ymd_His", $micro[1]) . '_' . (explode('.', $micro[0])[1]);
        $extension = image_type_to_extension(exif_imagetype($file));
        $dir = "$article_id";
        $fileName = $date . '-' . sha1_file($file) . $extension;


        $image = new Image();
        $image->article_id = $article_id;
        $image->url = $fileName;
        $image->save();

        $file->storeAs($dir, $fileName, ['disk' => 'local']);

        return $image->id;
    }
}
