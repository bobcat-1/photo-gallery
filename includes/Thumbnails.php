<?php

class Thumbnails
{
    const Quality = 100;
    const Size = 250;

    public static function getThumbnail($outfile, $infile){
        $im = imagecreatefromjpeg($infile);
        $idata = getimagesize($infile);
        $oldw = $idata[0];
        $oldh = $idata[1];

        if($oldw > $oldh){
            $w = self::Size;
            $h = (int)$oldh*$w/$oldw;
        } else {
            $h = self::Size;
            $w = (int)$oldw*$h/$oldh;
        }

        $im1=imagecreatetruecolor($w,$h);
        imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

        imagejpeg($im1, $outfile, self::Quality);
        imagedestroy($im);
        imagedestroy($im1);
    }
}