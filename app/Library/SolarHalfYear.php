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
 * 陽曆半年
 */
class SolarHalfYear
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

    /**
     * 一個半年的月數
     *
     * @var int
     */
    public static $MONTH_COUNT = 6;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function __toString()
    {
        return $this->year.'.'.$this->getIndex();
    }

    public function toFullString()
    {
        return $this->year.'年'.(1 === $this->getIndex() ? '上' : '下').'半年';
    }

    /**
     * 通過指定年月獲取陽曆半年
     *
     * @param  int  $year 年
     * @param  int  $month 月，1到12
     * @return SolarHalfYear
     */
    public static function fromYm($year, $month)
    {
        return new SolarHalfYear($year, $month);
    }

    /**
     * 通過指定日期獲取陽曆半年
     *
     * @param  DateTime  $date 日期DateTime
     * @return SolarHalfYear
     */
    public static function fromDate($date)
    {
        $year = (int) date_format($date, 'Y');
        $month = (int) date_format($date, 'n');

        return new SolarHalfYear($year, $month);
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
     * 獲取當月是第幾半年，從1開始
     *
     * @return int
     */
    public function getIndex()
    {
        return (int) ceil($this->month / SolarHalfYear::$MONTH_COUNT);
    }

    /**
     * 獲取本半年的月份
     *
     * @return array
     */
    public function getMonths()
    {
        $l = [];
        $index = $this->getIndex() - 1;
        for ($i = 0; $i < SolarHalfYear::$MONTH_COUNT; $i++) {
            $l[] = new SolarHalfYear($this->year, SolarHalfYear::$MONTH_COUNT * $index + $i + 1);
        }

        return $l;
    }

    /**
     * 半年推移
     *
     * @param  int  $halfYears 推移的半年數，負數為倒推
     * @return SolarHalfYear|null
     */
    public function next($halfYears)
    {
        if (0 === $halfYears) {
            return new SolarHalfYear($this->year, $this->month);
        }
        try {
            $date = new DateTime($this->year.'-'.$this->month.'-1');
        } catch (Exception $e) {
            return null;
        }
        $date->modify((SolarHalfYear::$MONTH_COUNT * $halfYears).' month');

        return SolarHalfYear::fromDate($date);
    }
}
