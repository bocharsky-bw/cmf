<?php

namespace BW\BlogBundle\Entity;

use BW\DefaultBundle\Entity\SluggableInterface;
use BW\RouterBundle\Entity\Route;
use BW\RouterBundle\Entity\RouteInterface;
use BW\DefaultBundle\Entity\NestedSetInterface;
use BW\UploadBundle\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Category
 * @package BW\BlogBundle\Entity
 */
class Category implements RouteInterface, NestedSetInterface, SluggableInterface
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
     * @var string $metaDescription
     */
    private $metaDescription = '';

    /**
     * @var string $shortDescription
     */
    private $shortDescription = '';

    /**
     * @var string $description
     */
    private $description = '';

    /**
     * @var boolean $published
     */
    private $published = true;

    /**
     * @var \DateTime $created
     */
    private $created;

    /**
     * @var \DateTime $updated
     */
    private $updated;

    /**
     * @var integer
     */
    private $root;

    /**
     * @var integer $order
     */
    private $order = 0;

    /**
     * @var integer $level
     */
    private $level = 0;

    /**
     * @var integer $left
     */
    private $left = 0;

    /**
     * @var integer $right
     */
    private $right = 0;

    /**
     * @var \BW\BlogBundle\Entity\Category $parent
     */
    private $parent;

    /**
     * @var ArrayCollection $children
     */
    private $children;

    /**
     * @var ArrayCollection $posts
     */
    private $posts;

    /**
     * @var Route $route
     */
    private $route;

    /**
     * @var \BW\UploadBundle\Entity\Image
     */
    private $image;


    /**
     * The constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->children = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return str_repeat('- ', $this->level) . $this->heading;
    }


    public function generateUpdatedDate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Generate current nested level
     *
     * ORM\PrePersist
     * ORM\PreUpdate
     * @return integer
     */
    public function generateLevel()
    {
        $this->level = 0;
        $parent = $this->getParent();

        while ($parent) {
            $this->level++;
            $parent = $parent->getParent();
        }

        return $this;
    }

    public function generatePath()
    {
        $slug = $this->getSlug();

        if (0 !== strcmp('/', $slug[0])) {
            $segments = array();
            $parent = $this->getParent();

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
            '_controller' => 'BWBlogBundle:Category:show',
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
     * @return Category
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * Set published
     *
     * @param boolean $published
     * @return Category
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
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
     * Set root
     *
     * @param integer $root
     * @return Category
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set left
     *
     * @param integer $left
     * @return Category
     */
    public function setLeft($left)
    {
        $this->left = $left;
        return $this;
    }

    /**
     * Get left
     *
     * @return integer 
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set right
     *
     * @param integer $right
     * @return Category
     */
    public function setRight($right)
    {
        $this->right = $right;
        return $this;
    }

    /**
     * Get right
     *
     * @return integer 
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Add children
     *
     * @param \BW\BlogBundle\Entity\Category $children
     * @return Category
     */
    public function addChild(Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \BW\BlogBundle\Entity\Category $children
     */
    public function removeChild(Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \BW\BlogBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return \BW\BlogBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Remove posts
     *
     * @param \BW\BlogBundle\Entity\Post $posts
     */
    public function removePost(Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Add posts
     *
     * @param \BW\BlogBundle\Entity\Post $posts
     * @return Category
     */
    public function addPost(Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
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
     * @return Category
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
