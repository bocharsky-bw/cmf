<?php

namespace BW\UploadBundle\Service;

use BW\UploadBundle\File\DestinationImage;
use BW\UploadBundle\File\SourceImage;

/**
 * The OOP abstract layout works with JPG, PNG & GIF image types with GD library functions
 *
 * Class ImageResizingService
 * @package BW\ImageBundle\Service
 */
class ImageResizingService
{
    /**
     * @var \BW\UploadBundle\File\SourceImage The source Image file object
     */
    private $srcImage;

    /**
     * @var \BW\UploadBundle\File\DestinationImage The destination Image object
     */
    private $dstImage;


    /**
     * The constructor
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
    }

    /**
     * The initialize the image objects
     *
     * @param string $filename
     * @return $this
     */
    public function init($filename)
    {
        $this->setSrcImage(new SourceImage($filename));
        $this->setDstImage(new DestinationImage());

        return $this;
    }


    /**
     * Crop the image to width and height
     *
     * @param int $width The width in pixels
     * @param int $height The height in pixels
     * @return $this
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @TODO Maybe to add mode for cropping with scale or without scale
     */
    public function crop($width, $height)
    {
        $this->getDstImage()->setWidth($width);
        $this->getDstImage()->setHeight($height);

        if ($this->getSrcImage()->getWidth() / $this->getDstImage()->getWidth()
            > $this->getSrcImage()->getHeight() / $this->getDstImage()->getHeight()
        ) {
            // resize to height
            $factor = $height / $this->getSrcImage()->getHeight();
            $this->getDstImage()->setWidth(
                $this->getSrcImage()->getWidth() * $factor
            );
            $this->getDstImage()->setHeight(
                $this->getSrcImage()->getHeight() * $factor
            );
            $this->getDstImage()->setOffsetX(
                ($width - $this->getDstImage()->getWidth()) / 2
            );
        } else {
            // resize to width
            $factor = $width / $this->getSrcImage()->getWidth();
            $this->getDstImage()->setHeight(
                $this->getSrcImage()->getHeight() * $factor
            );
            $this->getDstImage()->setWidth(
                $this->getSrcImage()->getWidth() * $factor
            );
            $this->getDstImage()->setOffsetY(
                ($height - $this->getDstImage()->getHeight()) / 2
            );
        }

        $this->getDstImage()->createResource($width, $height);
        $this->resampling();

        return $this;
    }

    /**
     * Resize the image to width and height
     *
     * @param int $width The width in pixels
     * @param int $height The height in pixels
     * @return $this
     */
    public function resize($width, $height)
    {
        $this->getDstImage()->setWidth($width);
        $this->getDstImage()->setHeight($height);

        $this->getDstImage()->createResource();
        $this->resampling();

        return $this;
    }

    /**
     * Resize the image to width
     *
     * @param int $width The width in pixels
     * @return $this
     */
    public function resizeToWidth($width)
    {
        $this->getDstImage()->setWidth($width);
        $divider = $this->getSrcImage()->getWidth() / $this->getSrcImage()->getHeight();
        $this->getDstImage()->setHeight(
            $this->getDstImage()->getWidth() / $divider
        );

        $this->getDstImage()->createResource();
        $this->resampling();

        return $this;
    }

    /**
     * Resize the image to height
     *
     * @param int $height The height in pixels
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function resizeToHeight($height)
    {
        $this->getDstImage()->setHeight($height);
        $factor = $this->getSrcImage()->getWidth() / $this->getSrcImage()->getHeight();
        $this->getDstImage()->setWidth(
            $this->getDstImage()->getHeight() * $factor
        );

        $this->getDstImage()->createResource();
        $this->resampling();

        return $this;
    }

    /**
     * Scale the image
     *
     * @param int|float $scale The scale in relative units
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function scale($scale)
    {
        $factor = (float)$scale;
        if (0 >= $factor) {
            throw new \InvalidArgumentException(sprintf(
                'The scale must be greater then 0, %d given.', $scale
            ));
        }
        $this->getDstImage()->setWidth(
            $this->getSrcImage()->getWidth() * $factor
        );
        $this->getDstImage()->setHeight(
            $this->getSrcImage()->getHeight() * $factor
        );

        $this->getDstImage()->createResource();
        $this->resampling();

        return $this;
    }

    /**
     * The Image resampling
     *
     * @return bool
     * @throws \Exception
     */
    private function resampling()
    {
        $success = imagecopyresampled(
            $this->getDstImage()->getResource(), /** @TODO Maybe check if resource is null - create them */
            $this->getSrcImage()->createResource()->getResource(),
            $this->getDstImage()->getOffsetX(),
            $this->getDstImage()->getOffsetY(),
            $this->getSrcImage()->getOffsetX(),
            $this->getSrcImage()->getOffsetY(),
            $this->getDstImage()->getWidth(),
            $this->getDstImage()->getHeight(),
            $this->getSrcImage()->getWidth(),
            $this->getSrcImage()->getHeight()
        );

        if ( ! $success) {
            throw new \RuntimeException('The destination image resampling failed.');
        }

        return $success;
    }

    /**
     * Save the Image to the host
     *
     * @return bool
     * @throws \Exception
     */
    public function save()
    {
        $this->getDstImage()->setFilename(
            $this->getSrcImage()->getFilename() . '_'
        );
        $this->getDstImage()->setPath(
            $this->getSrcImage()->getPath()
        );
        if ( ! is_dir($this->getDstImage()->getPath())) {
            // Create not exists folders recursively
            if ( ! mkdir($this->getDstImage()->getPath(), 0755, true)) {
                throw new \Exception(sprintf(
                    'Could not create a folder "%s"', $this->getDstImage()->getPath()
                ));
            }
        }

        $success = imagejpeg(
            $this->getDstImage()->getResource(),
            $this->getDstImage()->getPathname(),
            $this->getDstImage()->getQuality()
        );

        return $success;
    }


    /* SETTERS / GETTERS */

    /**
     * @return SourceImage
     */
    public function getSrcImage()
    {
        return $this->srcImage;
    }

    /**
     * @param SourceImage $srcImage
     */
    public function setSrcImage(SourceImage $srcImage)
    {
        $this->srcImage = $srcImage;
    }

    /**
     * @return DestinationImage
     */
    public function getDstImage()
    {
        return $this->dstImage;
    }

    /**
     * @param DestinationImage $dstImage
     */
    public function setDstImage(DestinationImage $dstImage)
    {
        $this->dstImage = $dstImage;
    }
}