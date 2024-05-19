<?php

if (!function_exists('resize_image')) {
    function resize_image($file, $w, $h)
    {
        try {
            [$width, $height] = getimagesize($file);
            $r = $width / $height;

            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }

            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if ($ext === 'png') {
                $src = imagecreatefrompng($file);
            } else if ($ext === 'jpeg' || $ext === 'jpg') {
                $src = imagecreatefromjpeg($file);
            } else {
                throw new Exception('Unsupported image type');
            }

            $dst = imagecreatetruecolor($newwidth, $newheight);

            // Center the image
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            if ($ext === 'png') {
                imagepng($dst, $file);
            } else if ($ext === 'jpeg' || $ext === 'jpg') {
                imagejpeg($dst, $file);
            } else {
                throw new Exception('Unsupported image type');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
