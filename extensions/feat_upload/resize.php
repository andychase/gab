<?php
use PHPImageWorkshop\ImageWorkshop;

function resize($from, $to, $width, $height) {
    include 'libs/GifCreator.php';
    include 'libs/GifFrameExtractor.php';
    require_once('PHPImageWorkshop/ImageWorkshop.php');
    if (GifFrameExtractor::isAnimatedGif($from)) {
        $gfe = new GifFrameExtractor();
        $frames = $gfe->extract($from);

        $retouchedFrames = array();
        // For each frame, we add a watermark and we resize it
        foreach ($frames as $frame) {
            $frameLayer = ImageWorkshop::initFromResourceVar($frame['image']);
            $frameLayer->resizeInPixel($width, null, true); // Resizing
            $retouchedFrames[] = $frameLayer->getResult();
        }
        $gc = new GifCreator();
        $gc->create($retouchedFrames, $gfe->getFrameDurations(), 0);
        file_put_contents($to, $gc->getGif());
    } else {
        include('libs/simpleimage.php');
        $image = new SimpleImage($from);
        if ($image->get_width() > $width || $image->get_height() > $height)
            // Too big? Resize
            $image->best_fit($width, $height);
        else
            // Resize anyway for security
            $image->fit_to_width($image->get_width());
        $image->save($to);
    }
}