<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileSecurity extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function files(Request $request)
    {
        $fileUrl = explode("/files/", $request->url());
        $fileUrl = array_pop($fileUrl);
        $localPath = "/local/" . $fileUrl;
        if (Storage::exists($localPath)) {
            $fileExt = explode(".", $fileUrl);
            $fileExt = array_pop($fileExt);
            $streamable = [
                "jpg",
                "jpeg",
                "gif",
                "png",
                "bmp",
                "pdf",
                "pptx",
                "xlsx",
                "xls",
                "csv",
                "ppt",
            ];
            if (in_array(strtolower($fileExt), $streamable)) {
                return Storage::response($localPath);
            } else {
                return Storage::download($localPath);
            }
        }
        abort(404);
    }
}
