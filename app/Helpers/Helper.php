<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

if (!function_exists("presentableDate")) {
    function presentableDate($date = "")
    {
        if (!$date || $date == "") {
            return "";
        }

        return Carbon::parse($date)->format("d/m/Y");
    }
}

if (!function_exists("dateDiffDays")) {
    function dateDiffDays(string $date1 = null, $date2 = null)
    {
        if (!$date1) {
            return false;
        }
        $date2 = $date2 == null ? Carbon::now() : $date2;
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInDays($date2);
    }
}

if (!function_exists("workflowCaseOpenUrl")) {
    function workflowCaseOpenUrl($appUID = "")
    {
        return env("PM_SERVER") .
        "/sys" .
        env("PM_WORKSPACE") .
            "/en/robiux/init/open?id=" .
            $appUID .
            "&index=1&action=todo";
    }
}

if (!function_exists("getFileTypeIcon")) {
    function getFileTypeIcon($fileUrl)
    {
        $ext = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
        switch (true) {
            case in_array($ext, ["jpg", "jpeg", "webp", "png"]):
                $fileIcon = "mdi mdi-file-image";
                break;
            case in_array($ext, ["xls", "xlsx"]):
                $fileIcon = "mdi mdi-file-excel";
                break;
            case $ext === "csv":
                $fileIcon = "mdi mdi-file-document";
                break;
            case $ext === "pdf":
                $fileIcon = "mdi mdi-file-pdf";
                break;
            case $ext === "msg":
                $fileIcon = "mdi mdi-email";
                break;
            default:
                $fileIcon = "mdi mdi-file-document";
        }
        return $fileIcon;
    }
}

if (!function_exists("requestFirstSegment")) {
    function requestFirstSegment()
    {
        return Request::segment(1);
    }
}
