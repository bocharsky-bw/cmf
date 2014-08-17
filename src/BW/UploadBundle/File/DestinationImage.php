<?php

namespace BW\UploadBundle\File;

/**
 * Class DestinationImage
 * @package BW\UploadBundle\File
 */
class DestinationImage
{
    /**
     * @var int The destination image quality in JPG format
     */
    private $quality = 75;

    /**
     * @var int The destination image width
     */
    private $width;

    /**
     * @var int The destination image height
     */
    private $height;

    /**
     * @var int The destination image offset by X
     */
    private $offsetX = 0;

    /**
     * @var int The destination image offset by Y
     */
    private $offsetY = 0;

    /**
     * @var string The destination image path
     */
    private $path;

    /**
     * @var string The destination image filename
     */
    private $filename;

    /**
     * @var string The destination image pathname
     */
    private $pathname;

    /**
     * @var resource The destination image resource
     */
    private $resource;


    /**
     * The constructor
     */
    public function __construct()
    {
    }


    /**
     * Create destination Image resource
     *
     * @param null $width
     * @param null $height
     * @return $this
     */
    public function createResource($width = null, $height = null)
    {
        /** @TODO Need to create resource based on mime type */
        $resource = imagecreatetruecolor(
            $width ? $width : $this->getWidth(),
            $height ? $height : $this->getHeight()
        );

        $this->setResource($resource);

        return $this;
    }


    /* SETTERS / GETTERS */

    /**
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->quality = (int)$quality;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = (int)$width;

        if (0 >= $this->width) {
            throw new \InvalidArgumentException(sprintf(
                'The width must be greater then 0, %d given.', $this->width
            ));
        }
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = (int)$height;

        if (0 >= $this->height) {
            throw new \InvalidArgumentException(sprintf(
                'The height must be greater then 0, %d given.', $this->height
            ));
        }
    }

    /**
     * @return int
     */
    public function getOffsetX()
    {
        return $this->offsetX;
    }

    /**
     * @param int $offsetX
     */
    public function setOffsetX($offsetX)
    {
        $this->offsetX = (int)$offsetX;
    }

    /**
     * @return int
     */
    public function getOffsetY()
    {
        return $this->offsetY;
    }

    /**
     * @param int $offsetY
     */
    public function setOffsetY($offsetY)
    {
        $this->offsetY = (int)$offsetY;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = (string)$path;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = (string)$filename;
    }

    /**
     * @return string
     */
    public function getPathname()
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . $this->getFilename();
    }

//    /**
//     * @param string $pathname
//     */
//    public function setPathname($pathname)
//    {
//        $this->pathname = (string)$pathname;
//    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param resource $resource
     */
    private function setResource($resource)
    {
        $this->resource = $resource;
    }
}
