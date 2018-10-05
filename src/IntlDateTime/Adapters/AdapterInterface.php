<?php

namespace IntlDateTime\Adapters;

use IntlDateTime\DateTime;
use IntlDateTime\DateTimeObject;

interface AdapterInterface 
{
    /**
     * Converts date into gregorian
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return DateTimeObject
     */
    public function convert($year, $month, $day): DateTimeObject;

    /**
     * Converts date from gregorian into an adapter
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return DateTimeObject
     */
    public function convertBack($year, $month, $day): DateTimeObject;

    /**
     * Returns date formatted according to given format
     *
     * @param DateTime $date
     * @param string $format
     * @return string
     */
    public function format(DateTime $date, string $format): string;
}