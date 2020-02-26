<?php

namespace App\Entity;

class PropertySearch
{
    /**
     * true : Rental
     * false : Sale
     * null : All
     *
     * @var bool|null
     */
    private $isrental = null;

    /**
     * @var int|null
     */
    private $minArea = null;

    /**
     * @var int|null
     */
    private $maxArea = null;

    /**
     * @var int|null
     */
    private $rooms = null;

    /**
     * @var int|null
     */
    private $bedrooms = null;

    /**
     * @var int|null
     */
    private $minprice = null;

    /**
     * @var int|null
     */
    private $maxprice = null;

    /**
     * @var int|null
     */
    private $propertyType = null;

    /**
     * true : Rental
     * false : Sale
     * null : All
     *
     * @var bool|null
     */
    private $isvisible = null;

    /**
     * true : Rental
     * false : Sale
     * null : All
     *
     * @var bool|null
     */
    private $istop = null;

    /**
     * true : Rental
     * false : Sale
     * null : All
     *
     * @var bool|null
     */
    private $isdeleted = null;

    /**
     * Get null : All
     *
     * @return  bool|null
     */
    public function getIsrental()
    {
        return $this->isrental;
    }

    /**
     * Set null : All
     *
     * @param  bool|null  $isrental  null : All
     *
     * @return  self
     */
    public function setIsrental($isrental)
    {
        $this->isrental = $isrental;

        return $this;
    }

    /**
     * Get the value of minArea
     *
     * @return  int|null
     */
    public function getMinArea()
    {
        return $this->minArea;
    }

    /**
     * Set the value of minArea
     *
     * @param  int|null  $minArea
     *
     * @return  self
     */
    public function setMinArea($minArea)
    {
        $this->minArea = $minArea;

        return $this;
    }

    /**
     * Get the value of maxArea
     *
     * @return  int|null
     */
    public function getMaxArea()
    {
        return $this->maxArea;
    }

    /**
     * Set the value of maxArea
     *
     * @param  int|null  $maxArea
     *
     * @return  self
     */
    public function setMaxArea($maxArea)
    {
        $this->maxArea = $maxArea;

        return $this;
    }

    /**
     * Get the value of rooms
     *
     * @return  int|null
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set the value of rooms
     *
     * @param  int|null  $rooms
     *
     * @return  self
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get the value of bedrooms
     *
     * @return  int|null
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set the value of bedrooms
     *
     * @param  int|null  $bedrooms
     *
     * @return  self
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get the value of minprice
     *
     * @return  int|null
     */
    public function getMinprice()
    {
        return $this->minprice;
    }

    /**
     * Set the value of minprice
     *
     * @param  int|null  $minprice
     *
     * @return  self
     */
    public function setMinprice($minprice)
    {
        $this->minprice = $minprice;

        return $this;
    }

    /**
     * Get the value of maxprice
     *
     * @return  int|null
     */
    public function getMaxprice()
    {
        return $this->maxprice;
    }

    /**
     * Set the value of maxprice
     *
     * @param  int|null  $maxprice
     *
     * @return  self
     */
    public function setMaxprice($maxprice)
    {
        $this->maxprice = $maxprice;

        return $this;
    }

    /**
     * Get the value of propertyType
     *
     * @return  int|null
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * Set the value of propertyType
     *
     * @param  int|null  $propertyType
     *
     * @return  self
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    /**
     * Get null : All
     *
     * @return  bool|null
     */
    public function getIsvisible()
    {
        return $this->isvisible;
    }

    /**
     * Set null : All
     *
     * @param  bool|null  $isvisible  null : All
     *
     * @return  self
     */
    public function setIsvisible($isvisible)
    {
        $this->isvisible = $isvisible;

        return $this;
    }

    /**
     * Get null : All
     *
     * @return  bool|null
     */
    public function getIstop()
    {
        return $this->istop;
    }

    /**
     * Set null : All
     *
     * @param  bool|null  $istop  null : All
     *
     * @return  self
     */
    public function setIstop($istop)
    {
        $this->istop = $istop;

        return $this;
    }

    /**
     * Get null : All
     *
     * @return  bool|null
     */
    public function getIsdeleted()
    {
        return $this->isdeleted;
    }

    /**
     * Set null : All
     *
     * @param  bool|null  $isdeleted  null : All
     *
     * @return  self
     */
    public function setIsdeleted($isdeleted)
    {
        $this->isdeleted = $isdeleted;

        return $this;
    }
}
