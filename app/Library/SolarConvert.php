<?php
/**
 * lunar
 *
 * @author 6tail
 */

namespace App\Library;

namespace com\nlf\calendar\util;


use DateTime;
use Exception;

date_default_timezone_set('PRC');
bcscale(12);

/**
 * 陽曆日期
 */
class SolarConvert
{
    /**
     * 2000年儒略日數(2000-1-1 12:00:00 UTC)
     *
     * @var int
     */
    public static $J2000 = 2451545;

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
     * 日
     *
     * @var int
     */
    private $day;

    /**
     * 時
     *
     * @var int
     */
    private $hour;

    /**
     * 分
     *
     * @var int
     */
    private $minute;

    /**
     * 秒
     *
     * @var int
     */
    private $second;

    /**
     * 日期
     */
    private $calendar;

    public function __construct($year, $month, $day, $hour, $minute, $second)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        try {
            $this->calendar = new DateTime($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second);
        } catch (Exception $e) {
        }
    }

    public static function fromDate($date)
    {
        $year = (int) date_format($date, 'Y');
        $month = (int) date_format($date, 'n');
        $day = (int) date_format($date, 'j');
        $hour = (int) date_format($date, 'G');
        $minute = (int) date_format($date, 'i');
        $second = (int) date_format($date, 's');

        return new SolarConvert($year, $month, $day, $hour, $minute, $second);
    }

    private static function int2($v)
    {
        $v = floor(floatval($v));

        return $v < 0 ? $v + 1 : $v;
    }

    public static function fromJulianDay($julianDay)
    {
        $julianDay += 0.5;

        // 日數的整數部份
        $a = SolarConvert::int2($julianDay);
        // 日數的小數部分
        $f = $julianDay - $a;
        if ($a > 2299161) {
            $dd = SolarConvert::int2(($a - 1867216.25) / 36524.25);
            $a += 1 + $dd - SolarConvert::int2($dd / 4);
        }
        // 向前移4年零2個月
        $a += 1524;
        $y = SolarConvert::int2(($a - 122.1) / 365.25);
        // 去除整年日數后餘下日數
        $dd = $a - SolarConvert::int2(365.25 * $y);
        $m = (int) SolarConvert::int2($dd / 30.6001);
        // 去除整月日數后餘下日數
        $d = (int) SolarConvert::int2($dd - SolarConvert::int2($m * 30.6001));
        $y -= 4716;
        $m--;
        if ($m > 12) {
            $m -= 12;
        }
        if ($m <= 2) {
            $y++;
        }

        // 日的小數轉為時分秒
        $f *= 24;
        $h = (int) SolarConvert::int2($f);

        $f -= $h;
        $f *= 60;
        $mi = SolarConvert::int2($f);

        $f -= $mi;
        $f *= 60;
        $s = SolarConvert::int2($f);

        return SolarConvert::fromYmdHms($y, $m, $d, $h, $mi, $s);
    }

    public static function fromYmd($year, $month, $day)
    {
        return new SolarConvert($year, $month, $day, 0, 0, 0);
    }

    public static function fromYmdHms($year, $month, $day, $hour, $minute, $second)
    {
        return new SolarConvert($year, $month, $day, $hour, $minute, $second);
    }

    public function toYmd()
    {
        $month = $this->month;
        $day = $this->day;

        return $this->year.'-'.($month < 10 ? '0' : '').$month.'-'.($day < 10 ? '0' : '').$day;
    }

    public function toYmdHms()
    {
        $hour = $this->hour;
        $minute = $this->minute;
        $second = $this->second;

        return $this->toYmd().' '.($hour < 10 ? '0' : '').$hour.':'.($minute < 10 ? '0' : '').$minute.':'.($second < 10 ? '0' : '').$second;
    }

    public function toFullString()
    {
        $s = $this->toYmdHms();
        if ($this->isLeapYear()) {
            $s .= ' 閏年';
        }
        $s .= ' 星期'.$this->getWeekInChinese();
        foreach ($this->getFestivals() as $f) {
            $s .= ' ('.$f.')';
        }
        $s .= ' '.$this->getXingZuo().'座';

        return $s;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getMinute()
    {
        return $this->minute;
    }

    public function getSecond()
    {
        return $this->second;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function __toString()
    {
        return $this->toYmd();
    }

    public function isLeapYear()
    {
        return SolarUtil::isLeapYear($this->year);
    }

    public function getWeek()
    {
        return (int) $this->calendar->format('w');
    }

    public function getWeekInChinese()
    {
        return SolarUtil::$WEEK[$this->getWeek()];
    }

    public function getXingZuo()
    {
        $index = 11;
        $m = $this->month;
        $d = $this->day;
        $y = $m * 100 + $d;
        if ($y >= 321 && $y <= 419) {
            $index = 0;
        } elseif ($y >= 420 && $y <= 520) {
            $index = 1;
        } elseif ($y >= 521 && $y <= 620) {
            $index = 2;
        } elseif ($y >= 621 && $y <= 722) {
            $index = 3;
        } elseif ($y >= 723 && $y <= 822) {
            $index = 4;
        } elseif ($y >= 823 && $y <= 922) {
            $index = 5;
        } elseif ($y >= 923 && $y <= 1022) {
            $index = 6;
        } elseif ($y >= 1023 && $y <= 1121) {
            $index = 7;
        } elseif ($y >= 1122 && $y <= 1221) {
            $index = 8;
        } elseif ($y >= 1222 || $y <= 119) {
            $index = 9;
        } elseif ($y <= 218) {
            $index = 10;
        }

        return SolarUtil::$XING_ZUO[$index];
    }

    public function getFestivals()
    {
        $l = [];
        if (! empty(SolarUtil::$FESTIVAL[$this->month.'-'.$this->day])) {
            $l[] = SolarUtil::$FESTIVAL[$this->month.'-'.$this->day];
        }
        $week = $this->getWeek();
        $weekInMonth = ceil(($this->day - $week) / 7);
        if ($week > 0) {
            $weekInMonth++;
        }
        if (! empty(SolarUtil::$WEEK_FESTIVAL[$this->month.'-'.$weekInMonth.'-'.$week])) {
            $l[] = SolarUtil::$WEEK_FESTIVAL[$this->month.'-'.$weekInMonth.'-'.$week];
        }

        return $l;
    }

    public function getOtherFestivals()
    {
        $l = [];
        if (! empty(SolarUtil::$OTHER_FESTIVAL[$this->month.'-'.$this->day])) {
            $l[] = SolarUtil::$OTHER_FESTIVAL[$this->month.'-'.$this->day];
        }

        return $l;
    }

    /**
     * 獲取往後推幾天的陽曆日期，如果要往前推，則天數用負數
     *
     * @param  int  $days 天數
     * @return Solar|null
     */
    public function next($days)
    {
        if ($days == 0) {
            return SolarConvert::fromYmdHms($this->year, $this->month, $this->day, $this->hour, $this->minute, $this->second);
        }
        try {
            $calendar = new DateTime($this->year.'-'.$this->month.'-'.$this->day.' '.$this->hour.':'.$this->minute.':'.$this->second);
        } catch (Exception $e) {
            return null;
        }
        $calendar->modify(($days > 0 ? '+' : '').$days.' day');

        return SolarConvert::fromDate($calendar);
    }
}
