<?php
/**
 * lunar
 *
 * @author 6tail
 */

namespace App\Library;

namespace com\nlf\calendar\util;

use DateTime;

date_default_timezone_set('PRC');
bcscale(12);

/**
 * 陽曆月
 */
class SolarMonth
{
    /**
     * 年
     *
     * @var int
     */
    private $year;

    /**
     * 月
     *
     * @var int
     */
    private $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function __toString()
    {
        return $this->year.'-'.$this->month;
    }

    public function toFullString()
    {
        return $this->year.'年'.$this->month.'月';
    }

    /**
     * 通過指定年月獲取陽曆月
     *
     * @param  int  $year 年
     * @param  int  $month 月，1到12
     * @return SolarMonth
     */
    public static function fromYm($year, $month)
    {
        return new SolarMonth($year, $month);
    }

    /**
     * 通過指定日期獲取陽曆月
     *
     * @param  DateTime  $date 日期DateTime
     * @return SolarMonth
     */
    public static function fromDate($date)
    {
        $year = (int) date_format($date, 'Y');
        $month = (int) date_format($date, 'n');

        return new SolarMonth($year, $month);
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    /**
     * 獲取本月的陽曆日期列表
     *
     * @return array
     */
    public function getDays()
    {
        $l = [];
        $d = SolarConvert::fromYmd($this->year, $this->month, 1);
        $l[] = $d;
        $days = SolarUtil::getDaysOfMonth($this->year, $this->month);
        for ($i = 1; $i < $days; $i++) {
            $l[] = $d->next($i);
        }

        return $l;
    }

    /**
     * 獲取往後推幾個月的陽曆月，如果要往前推，則月數用負數
     *
     * @param  int  $months 月數
     * @return SolarMonth|null
     */
    public function next($months)
    {
        try {
            $date = new DateTime($this->year.'-'.$this->month.'-1');
        } catch (Exception $e) {
            return null;
        }
        $date->modify($months.' month');

        return SolarMonth::fromDate($date);
    }
}
