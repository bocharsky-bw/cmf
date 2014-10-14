<?php

namespace BW\BlogBundle\Entity;

use BW\DefaultBundle\Entity\SluggableInterface;
use BW\RouterBundle\Entity\Route;
use BW\RouterBundle\Entity\RouteInterface;
use BW\UploadBundle\Entity\Image;

/**
 * Class Post
 * @package BW\BlogBundle\Entity
 */
class Post implements RouteInterface, SluggableInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $heading
     */
    private $heading = '';

    /**
     * @var string $slug
     */
    private $slug = '';

    /**
     * @var string $title
     */
    private $title = '';

    /**
     * @var string$metaDescription
     */
    private $metaDescription = '';

    /**
     * @var string $shortDescription
     */
    private $shortDescription = '';

    /**
     * @var string $content
     */
    private $description = '';

    /**
     * @var string $class
     */
    private $class = '';

    /**
     * @var boolean $published
     */
    private $published = true;

    /**
     * @var integer $order
     */
    private $order = 0;

    /**
     * @var \DateTime $created
     */
    private $created;

    /**
     * @var \DateTime $updated
     */
    private $updated;

    /**
     * @var Category $category
     */
    private $category;

    /**
     * @var Route $route
     */
    private $route;

    /**
     * @var \BW\UploadBundle\Entity\Image
     */
    private $image;


    /**
     * Init entity
     */
    public function init()
    {
        $this->id = null;
        $this->slug = null;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->route = null;
        $this->image = null;
    }

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Clone current entity
     */
    public function __clone()
    {
        $this->init();
    }


    public function generateUpdatedDate()
    {
        $this->updated = new \DateTime();
    }

    public function generatePath()
    {
        $slug = $this->getSlug();
        $first = isset($slug[0]) ? $slug[0] : '';

        if (0 !== strcmp('/', $first)) {
            $segments = array();
            $parent = $this->getCategory();

            if ($parent) {
                $segments[] = ''; // Add slash to the end of path
            }

            while ($parent) {
                if ($parent->getSlug()) {
                    $segments[] = $parent->getSlug();
                }
                $parent = $parent->getParent();
            }

            $slug = '/' . implode('/', array_reverse($segments)) . $this->getSlug();
        }

        return $slug;
    }

    public function getDefaults()
    {
        if ( ! $this->getId()) {
            throw new \RuntimeException(''
                . 'The entity ID not defined. '
                . 'Maybe you forgot to execute "flush" method before handle the entity?'
            );
        }

        return array(
            '_controller' => 'BWBlogBundle:Post:show',
            'id' => $this->getId(),
        );
    }

    public function getStringForSlug()
    {
        return $this->getHeading();
    }


    /* SETTERS / GETTERS */
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set heading
     *
     * @param string $heading
     * @return Post
     */
    public function setHeading($heading)
    {
        $this->heading = isset($heading) ? $heading : '';

        return $this;
    }

    /**
     * Get heading
     *
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = isset($slug) ? $slug : '';

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = isset($title) ? $title : '';
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Post
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = isset($metaDescription) ? $metaDescription : '';
    
        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Post
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = isset($shortDescription) ? $shortDescription : '';
    
        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = isset($description) ? $description : '';
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set class
     *
     * @param string $class
     * @return Post
     */
    public function setClass($class)
    {
        $this->class = isset($class) ? $class : '';

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Is published
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Category
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set category
     *
     * @param \BW\BlogBundle\Entity\Category $category
     * @return Post
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \BW\BlogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set route
     *
     * @param \BW\RouterBundle\Entity\Route $route
     * @return Post
     */
    public function setRoute(Route $route = null)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \BW\RouterBundle\Entity\Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set image
     *
     * @param \BW\UploadBundle\Entity\Image $image
     * @return Post
     */
    public function setImage(Image $image = null)
    {
        $this->image = isset($image)
            ? (null !== $image->getFile() ? $image : null)
            : null
        ;

        return $this;
    }

    /**
     * Get image
     *
     * @return \BW\UploadBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
