<?php

namespace BW\DefaultBundle\EventListener;

use BW\DefaultBundle\EventListener\SluggableInterface;
use BW\DefaultBundle\Service\TransliteratingService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class SluggableEventListener
 * @package BW\DefaultBundle\EventListener
 */
class SluggableEventListener
{
    /**
     * @var TransliteratingService The TransliteratingService instance
     */
    private $transliter;

    /**
     * @var string The RegEx pattern of denied characters
     */
    private $deniedCharacters;

    /**
     * @var bool Whether is slug to lowercase
     */
    private $toLower;


    public function __construct(
        TransliteratingService $transliter,
        $deniedCharacters = '/[^0-9A-Za-z_-]/',
        $toLower = true
    ) {
        $this->transliter = $transliter;
        $this->deniedCharacters = $deniedCharacters;
        $this->toLower = $toLower;
    }


    /**
     * Translit cyrillic to latin string for use in browser address bar
     *
     * @param string $string The cyrillic string to translit
     * @return string The translited latin slug
     **/
    public function toSlug($string)
    {
        $slug = $this->transliter->translit($string); // translit string
        $slug = preg_replace('/\s+|-+/i', '-', $slug); // replace few hyphens or spaces to one hyphen
        $slug = preg_replace($this->deniedCharacters, '', $slug); // remove forbidden characters
        if (true === $this->toLower) {
            $slug = strtolower($slug); // To lowercase
        }

        return $slug;
    }


    public function generateSlugFor(SluggableInterface $entity)
    {
        // If slug is empty, get slug from special slug string (heading, name, etc.)
        if ( ! $entity->getSlug()) {
            $entity->setSlug($entity->getStringForSlug());
        }

        // Filtering slug
        $slug = $entity->getSlug();
        $slug = $this->toSlug($slug);
        $entity->setSlug($slug);

        return $slug;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof SluggableInterface) {
            $this->generateSlugFor($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof SluggableInterface) {
            $this->generateSlugFor($entity);
        }
    }
}