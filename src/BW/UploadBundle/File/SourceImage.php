<?php

namespace BW\UploadBundle\File;

/**
 * Class SourceImage
 * @package BW\UploadBundle\File
 */
class SourceImage extends \SplFileInfo
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
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
     * @var int The IMAGETYPE_XXX constant number
     */
    private $type;

    /**
     * @var string
     */
    private $sizeForHtml;

    /**
     * @var integer
     */
    private $bits;

    /**
     * @var integer
     */
    private $channels;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var resource The image resource
     */
    private $resource;


    /**
     * The constructor
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        parent::__construct($filename);
        if ( ! $this->isFile()) {
            throw new \InvalidArgumentException(sprintf(
                'File does not exist at the specified path.'
            ));
        }

        try {
            $info = getimagesize($this->getRealPath());
            if ( ! is_array($info)) {
                throw new \Exception();
            }
            $this
                ->setWidth($info[0])
                ->setHeight($info[1])
                ->setType($info[2])
                ->setSizeForHtml($info[3])
                ->setBits($info['bits'])
                ->setChannels($info['channels'])
                ->setMimeType($info['mime'])
            ;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf(
                'File is not an image.'
            ));
        }
    }


    /**
     * Create the Image resource
     *
     * @return $this
     */
    public function createResource()
    {
        /** @TODO Need to create resource based on mime type */
        $resource = imagecreatefromjpeg($this->getRealPath());

        $this->setResource($resource);

        return $this;
    }


    /* SETTERS / GETTERS */

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return $this
     */
    private function setWidth($width)
    {
        $this->width = (int)$width;

        return $this;
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
     * @return $this
     */
    private function setHeight($height)
    {
        $this->height = (int)$height;

        return $this;
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
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return $this
     */
    private function setType($type)
    {
        $this->type = (int)$type;

        return $this;
    }

    /**
     * @return string
     */
    public function getSizeForHtml()
    {
        return $this->sizeForHtml;
    }

    /**
     * @param string $sizeForHtml
     * @return $this
     */
    private function setSizeForHtml($sizeForHtml)
    {
        $this->sizeForHtml = (string)$sizeForHtml;

        return $this;
    }

    /**
     * @return int
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * @param int $bits
     * @return $this
     */
    private function setBits($bits)
    {
        $this->bits = (int)$bits;

        return $this;
    }

    /**
     * @return int
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param int $channels
     * @return $this
     */
    private function setChannels($channels)
    {
        $this->channels = (int)$channels;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return $this
     */
    private function setMimeType($mimeType)
    {
        $this->mimeType = (string)$mimeType;

        return $this;
    }

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
