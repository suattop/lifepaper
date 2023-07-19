<?php
/**
 * lunar
 *
 * @author 6tail
 */

namespace App\Library;

namespace com\nlf\calendar\util;

date_default_timezone_set('PRC');
bcscale(12);

/**
 * 陽曆年
 */
class SolarYear
{
    /**
     * 年
     *
     * @var int
     */
    private $year;

    /**
     * 一年的月數
     *
     * @var int
     */
    public static $MONTH_COUNT = 12;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function __toString()
    {
        return $this->year.'';
    }

    public function toFullString()
    {
        return $this->year.'年';
    }

    /**
     * 通過指定年獲取陽曆年
     *
     * @param  int  $year 年
     * @return SolarYear
     */
    public static function fromYear($year)
    {
        return new SolarYear($year);
    }

    /**
     * 通過指定日期獲取陽曆年
     *
     * @param  DateTime  $date 日期DateTime
     * @return SolarYear
     */
    public static function fromDate($date)
    {
        $year = (int) date_format($date, 'Y');

        return new SolarYear($year);
    }

    public function getYear()
    {
        return $this->year;
    }

    /**
     * 獲取本年的月份
     *
     * @return array
     */
    public function getMonths()
    {
        $l = [];
        $month = SolarMonth::fromYm($this->year, 1);
        $l[] = $month;
        for ($i = 1; $i < SolarYear::$MONTH_COUNT; $i++) {
            $l[] = $month->next($i);
        }

        return $l;
    }

    /**
     * 年推移
     *
     * @param  int  $years 推移的年數，負數為倒推
     * @return SolarYear|null
     */
    public function next($years)
    {
        if (0 === $years) {
            return new SolarYear($this->year);
        }
        try {
            $date = new DateTime($this->year.'-1-1');
        } catch (Exception $e) {
            return null;
        }
        $date->modify($years.' year');

        return SolarYear::fromDate($date);
    }
}
