<?php

namespace BW\DefaultBundle\Service;

interface NestedSetInterface
{
    /**
     * The getter of $id
     * @return integer The ID of entity
     */
    public function getId();

    /**
     * The getter of $parent
     * @return NestedSetInterface The parent entity
     */
    public function getParent();

    /**
     * The setter of $level
     *
     * @param integer $level The level of entity
     * @return NestedSetInterface
     */
    public function setLevel($level);

    /**
     * The getter of $level
     * @return integer The level of entity
     */
    public function getLevel();

    /**
     * The setter of $left
     *
     * @param integer $left The left position of entity
     * @return NestedSetInterface
     */
    public function setLeft($left);

    /**
     * The getter of $left
     * @return integer The left position of entity
     */
    public function getLeft();

    /**
     * The setter of $right
     *
     * @param integer $right The right position of entity
     * @return NestedSetInterface
     */
    public function setRight($right);

    /**
     * The getter of $right
     * @return integer The right position of entity
     */
    public function getRight();
}
