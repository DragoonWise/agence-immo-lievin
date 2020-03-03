<?php

namespace App\Entity;

class PropertyExport
{
        /**
     * @var \DateTime
     */
    private $minDate;

    /**
     * @var \DateTime
     */
    private $maxDate;


    /**
     * Get the value of minDate
     *
     * @return  \DateTime
     */
    public function getMinDate()
    {
        return $this->minDate;
    }

    /**
     * Set the value of minDate
     *
     * @param  \DateTime  $minDate
     *
     * @return  self
     */
    public function setMinDate(\DateTime $minDate)
    {
        $this->minDate = $minDate;

        return $this;
    }

    /**
     * Get the value of maxDate
     *
     * @return  \DateTime
     */
    public function getMaxDate()
    {
        return $this->maxDate;
    }

    /**
     * Set the value of maxDate
     *
     * @param  \DateTime  $maxDate
     *
     * @return  self
     */
    public function setMaxDate(\DateTime $maxDate)
    {
        $this->maxDate = $maxDate;

        return $this;
    }
}