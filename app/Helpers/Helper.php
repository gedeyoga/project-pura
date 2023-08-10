<?php 

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

function uploadImage($image, $directory = 'upload')
{
    $name = time() . '-' . $image->getClientOriginalName();
    $image->move($directory, $name);

    return url($directory . '/' . $name);
}