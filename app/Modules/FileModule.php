<?php

namespace App\Modules;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileModule
{
    public static function upload(Request $request)
    {
        $fileName = $request->file->store('images', 'custom');

        return $fileName;
    }

    public static function delete($path)
    {
        Storage::disk('custom')->delete($path);
    }
}
