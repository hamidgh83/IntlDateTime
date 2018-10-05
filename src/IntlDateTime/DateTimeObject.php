<?php

namespace IntlDateTime;

class DateTimeObject 
{
    private $year;
    private $month;
    private $day;
    private $hour;
    private $minute;
    private $second;

    public function __construct($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null)
    {
        $this->year   = $year;
        $this->month  = $month;
        $this->day    = $day;
        $this->hour   = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }    

    /**
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of month
     */ 
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set the value of month
     *
     * @return  self
     */ 
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get the value of day
     */ 
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set the value of day
     *
     * @return  self
     */ 
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get the value of hour
     */ 
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Set the value of hour
     *
     * @return  self
     */ 
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get the value of minute
     */ 
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * Set the value of minute
     *
     * @return  self
     */ 
    public function setMinute($minute)
    {
        $this->minute = $minute;

        return $this;
    }

    /**
     * Get the value of second
     */ 
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * Set the value of second
     *
     * @return  self
     */ 
    public function setSecond($second)
    {
        $this->second = $second;

        return $this;
    }
}
