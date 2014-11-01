<?php

namespace BW\BreadcrumbsBundle\Service;

use BW\BreadcrumbsBundle\Entity\Crumb;

/**
 * Class BreadcrumbsService
 * @package BW\BreadcrumbsBundle\Service
 */
class BreadcrumbsService implements \Iterator, \Countable
{
    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var array
     */
    private $crumbs = [];

    /**
     * @var bool
     */
    private $navigation = true;

    /**
     * @var bool
     */
    private $showFirst = true;

    /**
     * @var bool
     */
    private $showLast = true;

    /**
     * @var bool
     */
    private $lastAsLink = false;

    /**
     * @var bool
     */
    private $showSeparator = true;

    /**
     * @var string
     */
    private $separatorCharacter = '/';


    public function __construct()
    {
        $this->crumbs = [
            self::buildCrumb('Home', '/'),
            self::buildCrumb('Category', '/category'),
            self::buildCrumb('SubCategory', '/category/subcategory'),
            self::buildCrumb('Post', '/category/subcategory/post'),
        ];
    }


    /**
     * @param string $name
     * @param string $uri
     *
     * @return Crumb
     */
    public static function buildCrumb($name = null, $uri = null)
    {
        return new Crumb($name, $uri);
    }

    /**
     * @param Crumb $crumb
     *
     * @return $this
     */
    public function addCrumb(Crumb $crumb)
    {
        $this->crumbs[] = $crumb;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNavigation()
    {
        return $this->navigation;
    }

    /**
     * @param boolean $navigation
     *
     * @return $this
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowFirst()
    {
        return $this->showFirst;
    }

    /**
     * @param $showFirst
     *
     * @return $this
     */
    public function setShowFirst($showFirst)
    {
        $this->showFirst = $showFirst;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowLast()
    {
        return $this->showLast;
    }

    /**
     * @param $showLast
     *
     * @return $this
     */
    public function setShowLast($showLast)
    {
        $this->showLast = $showLast;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isLastAsLink()
    {
        return $this->lastAsLink;
    }

    /**
     * @param bool $lastAsLink
     *
     * @return $this
     */
    public function setLastAsLink($lastAsLink)
    {
        $this->lastAsLink = (bool)$lastAsLink;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowSeparator()
    {
        return $this->showSeparator;
    }

    /**
     * @param $showSeparator
     *
     * @return $this
     */
    public function setShowSeparator($showSeparator)
    {
        $this->showSeparator = $showSeparator;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeparatorCharacter()
    {
        return $this->separatorCharacter;
    }

    /**
     * @param $separatorCharacter
     *
     * @return $this
     */
    public function setSeparatorCharacter($separatorCharacter)
    {
        $this->separatorCharacter = (string)$separatorCharacter;

        return $this;
    }

    /**
     * @return array
     */
    public function getCrumbs()
    {
        return $this->crumbs;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->crumbs);
    }

    /**
     * @return $this
     */
    public function rewind()
    {
        $this->position = 0;

        return $this;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->crumbs[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return $this
     */
    public function next()
    {
        ++$this->position;

        return $this;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->crumbs[$this->position]);
    }
}