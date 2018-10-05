<?php

namespace IntlDateTime\Adapters;

use IntlDateTime\DateTime;
use IntlDateTime\DateTimeObject;


class JalaliAdapter implements AdapterInterface
{
	const PERSIAN_WEEK_DAY = [
		"&#1610;&#1603;&#1588;&#1606;&#1576;&#1607;",
		"&#1583;&#1608;&#1588;&#1606;&#1576;&#1607;",
		"&#1587;&#1607; &#1588;&#1606;&#1576;&#1607;",
		"&#1670;&#1607;&#1575;&#1585;&#1588;&#1606;&#1576;&#1607;",
		"&#1662;&#1606;&#1580;&#8204;&#1588;&#1606;&#1576;&#1607;",
		"&#1580;&#1605;&#1593;&#1607;",
		"&#1588;&#1606;&#1576;&#1607;"
	]; 
	
	const PERSIAN_MONTHS = [
		"&#1601;&#1585;&#1608;&#1585;&#1583;&#1610;&#1606;",
		"&#1575;&#1585;&#1583;&#1610;&#1576;&#1607;&#1588;&#1578;",
		"&#1582;&#1585;&#1583;&#1575;&#1583;",
		"&#1578;&#1610;&#1585;",
		"&#1605;&#1585;&#1583;&#1575;&#1583;",
		"&#1588;&#1607;&#1585;&#1610;&#1608;&#1585;",
		"&#1605;&#1607;&#1585;",
		"&#1570;&#1576;&#1575;&#1606;",
		"&#1570;&#1584;&#1585;",
		"&#1583;&#1610;",
		"&#1576;&#1607;&#1605;&#1606;",
		"&#1575;&#1587;&#1601;&#1606;&#1583;"
	];

	/**
     * Converts jalali date into gregorian
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return DateTimeObject
     */
    public function convert($year, $month, $day): DateTimeObject
    {
		$g_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $j_days_in_month = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
	   
		$jy = $year - 979;
        $jm = $month - 1;
        $jd = $day - 1;
		
		$j_day_no = 365 * $jy + floor($jy / 33) * 8 + floor(($jy % 33 + 3) / 4);

        for ($i = 0; $i < $jm; ++$i){
            $j_day_no += $j_days_in_month[$i];
		}
		
        $j_day_no += $jd;
        $g_day_no  = $j_day_no+79;
        $gy        = 1600 + 400*floor($g_day_no/146097);
        $g_day_no  = $g_day_no % 146097;
        $leap      = true;
		
		if ($g_day_no >= 36525){
			$g_day_no--;
			
            $gy      += 100*floor($g_day_no / 36524);
            $g_day_no = $g_day_no % 36524;
			
			if ($g_day_no >= 365){
                $g_day_no++;
            } else {
                $leap = false;
            }
        }
		
		$gy       += 4*floor($g_day_no/1461);
        $g_day_no %= 1461;
		
		if ($g_day_no >= 366){
            $leap = false;
			
			$g_day_no--;
			
			$gy      += floor($g_day_no/365);
            $g_day_no = $g_day_no % 365;
        }
		
		for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++){
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        }
		
		$gm = $i + 1;
		$gd = $g_day_no + 1;
		
		return new DateTimeObject($gy, $gm, $gd);
    }

	/**
     * Converts date from gregorian into jalali
     *
     * @param int $year
     * @param int $month
     * @param int $day
     * @return DateTimeObject
     */
    public function convertBack($year, $month, $day): DateTimeObject
    {
		$g_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $j_days_in_month = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 2];
		
		$gy = $year - 1600;
        $gm = $month - 1;
        $gd = $day - 1;
        $g_day_no = 365 * $gy + self::div($gy + 3, 4)-self::div($gy + 99, 100) + self::div($gy + 399, 400);
		
		for ($i=0; $i < $gm; ++$i) {
			$g_day_no += $g_days_in_month[$i];
		}
		
		if ($gm > 1 && (($gy%4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0))) {
			$g_day_no++;
		}

        $g_day_no += $gd;
        $j_day_no = $g_day_no-79;
        $j_np = self::div($j_day_no, 12053);
        $j_day_no = $j_day_no % 12053;
        $jy = 979 + 33 * $j_np + 4 * self::div($j_day_no, 1461);
        $j_day_no %= 1461;
		
		if ($j_day_no >= 366) {
            $jy += self::div($j_day_no-1, 365);
            $j_day_no = ($j_day_no-1)%365;
        }
		
		for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
			$j_day_no -= $j_days_in_month[$i];
		}
		
		$jm = $i+1;
        $jd = $j_day_no+1;

		return new DateTimeObject($jy, $jm, $jd);
	}
	
	/**
     * Division
     */
    private static function div($a, $b)
    {
        return (int) ($a / $b);
    }

    /**
     * Returns date formatted according to given format
	 *
     * @param DateTime $date
     * @param string $format
     * @return mixed the formatted date string on success or FALSE on failure.
	 */
    public function format(DateTime $date, string $format): string
	{
		list($year, $month, $day, $week) = explode('-', $date->getParentFormat("Y-m-d-w")); 
		$dateTime                        = $this->convertBack($year, $month, $day);
		
		$template = [
			'y' => substr($dateTime->getYear(), -2),
			'Y' => $dateTime->getYear(),
			'M' => self::PERSIAN_MONTHS[$dateTime->getMonth() - 1],
			'm' => $dateTime->getMonth() < 10 ? '0' . $dateTime->getMonth() : $dateTime->getMonth(),
			'j' => $dateTime->getMonth(),
			'D' => self::PERSIAN_WEEK_DAY[$week],
			'W' => self::PERSIAN_WEEK_DAY[$week],
			'l' => self::PERSIAN_WEEK_DAY[$week],
			'd' => $dateTime->getDay()
		];

		return strtr($format, $template);
	}
}
