<?php

namespace BW\DefaultBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class NestedSet
 * @package BW\BlogBundle\Service
 */
class NestedSet {

    /**
     * @var \Doctrine\ORM\EntityManager The Doctrine entity manager object
     */
    private $em;

    /**
     * @var array The entity array, grouped by parent ID
     */
    private $groupedEntitiesByParent = array();

    /**
     * @var array The entity array, grouped by level
     */
    private $groupedEntitiesByLevel = array();

    /**
     * @var array The entity array, grouped by nested set
     */
    private $nestedEntities = array();


    /**
     * The constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Regenerate tree of nested set entities by level and parent ID
     *
     * @param string $entityName The entity name, like <b>AcmeDemoBundle:EntityName</b>
     */
    public function regenerate($entityName)
    {
        $this->em->flush(); // save to DB all unsaved entities

        $entities = $this->em->getRepository($entityName)->findBy(array(), array(
            'order' => 'ASC',
        )); // fetch from DB
        if ($entities) {
            // Clear data
            $this->clear();

            // Group entities by level and parent ID
            $this->group($entities);

            // Sort array keys by level ASC
            ksort($this->groupedEntitiesByLevel, SORT_NUMERIC);

            // Generate entities nested set
            $firstKey = key($this->groupedEntitiesByLevel); // get key of the first element (min level value)
            $this->nestedEntities = $this->groupedEntitiesByLevel[$firstKey];
            $this->nested($this->nestedEntities);

            // Order entities
            $this->order($this->nestedEntities);
            $this->em->flush(); // save to DB
        }
    }

    private function clear()
    {
        $this->groupedEntitiesByParent = array();
        $this->groupedEntitiesByLevel = array();
        $this->nestedEntities = array();
    }

    /**
     * Group entities by level and parent ID
     *
     * @param array $entities The array of fetched entities from DB
     */
    private function group(array $entities)
    {
        foreach ($entities as $entity) {
            if ( ! ($entity instanceof NestedSetInterface)) {
                throw new \UnexpectedValueException(''
                    . 'The entity must implement a "BW\DefaultBundle\Service\NestedSetInterface" interface '
                    . 'for determine positions'
                );
            }
            $entity_id = (int)$entity->getId();
            $parent_id = (int)($entity->getParent() ? $entity->getParent()->getId() : 0);
            $level = (int)$entity->getLevel();
            // Группирование по ID родителя
            $this->groupedEntitiesByParent[$parent_id][$entity_id]['entity'] = $entity;
            // Группирование по уровням
            $this->groupedEntitiesByLevel[$level][$entity_id]['entity'] = $entity;
        }
    }

    /**
     * Generate nested set entities by reference
     *
     * @param array &$nodes The array of nested set entities
     */
    private function nested(array &$nodes)
    {
        foreach ($nodes as $id => $node) {
            //var_dump('*');
            $nodes[$id]['children'] = array();
            if (isset($this->groupedEntitiesByParent[$id])) {
                $nodes[$id]['children'] = $this->groupedEntitiesByParent[$id];
                $this->nested($nodes[$id]['children']);
            }
        }
    }

    /**
     * Order left and right positions of nested set entities by reference
     *
     * @param array &$nodes The array of nested set entities
     * @param int &$left The left position of entity
     * @param int &$right The right position of entity
     */
    private function order(array &$nodes, &$left = 0, &$right = 0)
    {
        foreach ($nodes as $node) {
            if ( ! ($node['entity'] instanceof NestedSetInterface)) {
                throw new \UnexpectedValueException(''
                    . 'The entity must implement a "BW\DefaultBundle\Service\NestedSetInterface" interface '
                    . 'to determine positions'
                );
            }
            if ($node['children']) { // If children exists
                // Save current value of counter to the temp variable
                // for don't lose it when iterate children elements
                $lft = $right + 1;
                $right = $right + 1;

                $this->order($node['children'], $left, $right);
                $right = $right + 1;

                // set positions
                $node['entity']->setLeft($lft);
                $node['entity']->setRight($right);
            } else { // If children NOT exists
                $left = $right + 1;
                $right = $left + 1;

                // set positions
                $node['entity']->setLeft($left);
                $node['entity']->setRight($right);
            }
        }
    }
}