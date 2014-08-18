<?php

namespace BW\UploadBundle\Twig;

use BW\UploadBundle\Service\ImageResizingService;
use Symfony\Bridge\Monolog\Logger;

class BWExtension extends \Twig_Extension
{

    /**
     * The ImageResizingService instance
     * @var \BW\UploadBundle\Service\ImageResizingService
     */
    protected $resizer;

    /**
     * @var Logger The logger instance
     */
    private $logger;



    public function __construct(ImageResizingService $resizer, Logger $logger)
    {
        $this->resizer = $resizer;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded twig extension "%s".',
            __METHOD__
        ));
    }


    public function getName()
    {
        return 'bw_upload_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('crop', array($this, 'cropFilter')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('crop', array($this, 'cropFunction')),
        );
    }


    public function cropFilter($webPathname, $width, $height)
    {
        return $this->crop($webPathname, $width, $height);
    }

    public function cropFunction($webPathname, $width, $height)
    {
        return $this->crop($webPathname, $width, $height);
    }

    private function crop($webPathname, $width, $height)
    {
        $pathname = __DIR__ . '/../../../../web/cache/' . $width . 'x' . $height . $webPathname;

        if ( ! file_exists($pathname)) {
            $this
                ->resizer
                ->init('/' . $webPathname)
                ->crop($width, $height)
                ->save()
            ;
        }

        return $webPathname;
    }
}