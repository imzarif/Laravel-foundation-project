<?php

namespace App\Http\Traits;

trait ColorPickerTrait
{
    private function generateBgColorList($iteration = 0)
    {
        $bgColor = [];
        if ($iteration) {
            for ($i = 0; $i < $iteration; $i++) {
                array_push($bgColor, $this->randColor());
            }
        }
        return $bgColor;
    }

    private function randColor()
    {
        return '#' . str_pad(dechex(random_int(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
