<?php

namespace App\Http\Support;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageMagic
{
    public static function parseForFirstImageFromPDF($file, $fileNameOutput)
    {
        //Force to save file as png format
        $command = "/bin/convert -density 100 -colorspace rgb '".$file."[0]' -quality 100 " . $fileNameOutput;
        $outCommand = null;
        $return = null;
        exec($command, $outCommand, $return);
        Log::error("Get first image successfully: " . print_r(array($outCommand, $return, $command), true));
        return $fileNameOutput;
    }
}
