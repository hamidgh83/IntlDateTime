<?php
/**
 * This is an extension of PHP DateTime which is compatible with any other calendars like Jalali, Islamic, etc.
 * 
 * @author Seyed Hamid Ghorashi <h.ghorashi@gmail.com>
 * @version 1.0.0
 * @license MIT
 */

namespace IntlDateTime;

use DateTime as PHPDateTime;
use IntlDateTime\Adapters\AdapterInterface;

class DateTime extends PHPDateTime
{
	/**
	 * Calendar adapter
	 *
	 * @var CalendarAdapter
	 */
	public $adapter;

	public function __construct(string $time = "now", \DateTimeZone $timezone = NULL)
	{
		return parent::__construct($time, $timezone);
	}

	/**
	 * Set calendar type
	 *
	 * @param AdapterTypeInterface $type
	 * @return DateTime
	 */
	public function setAdapter($type)
	{
		$adapterName   = "\\IntlDateTime\\Adapters\\" .  ucwords($type) . 'Adapter';
		$this->adapter = new $adapterName();

		return $this;
	}

	/**
	 * Resets the current date of the DateTime object to a different date
	 *
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 * @return DateTime The DateTime object for method chaining or FALSE on failure.
	 */
	public function setDate($year, $month, $day)
	{
		if ($this->adapter instanceof AdapterInterface) {
			$dateTime = $this->adapter->convert($year, $month, $day);
			
			return parent::setDate($dateTime->getYear(), $dateTime->getMonth(), $dateTime->getDay());
		}

		return parent::setDate($year, $month, $day);
	}

	/**
	 * Returns date formatted according to given format
	 *
	 * @param string $format
	 * @return mixed the formatted date string on success or FALSE on failure.
	 */
	public function format($format)
	{
		if ($this->adapter instanceof AdapterInterface) {
			$format = $this->adapter->format($this, $format);
		}
		
		return parent::format($format);
	}

	/**
	 * Returns parent format
	 *
	 * @param string $format
	 * @return string
	 */
	public function getParentFormat($format)
	{
		return parent::format($format);
	}
}