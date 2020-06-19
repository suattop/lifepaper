<?php
/**
 * lunar
 * @author 6tail
 */
namespace App\Library;
namespace com\nlf\calendar\util;

use com\nlf\calendar\Holiday;

date_default_timezone_set('PRC');
bcscale(12);

/**
 * 陽曆季度
 * @package com\nlf\calendar
 */
class SolarSeason
{

  /**
   * 年
   * @var int
   */
  private $year;

  /**
   * 月
   * @var int
   */
  private $month;

  /**
   * 一個季度的月數
   * @var int
   */
  public static $MONTH_COUNT = 3;

  function __construct($year, $month)
  {
    $this->year = $year;
    $this->month = $month;
  }

  public function __toString()
  {
    return $this->year . '.' . $this->getIndex();
  }

  public function toFullString()
  {
    return $this->year . '年' . $this->getIndex() . '季度';
  }

  /**
   * 通過指定年月獲取陽曆季度
   * @param int $year 年
   * @param int $month 月，1到12
   * @return SolarSeason
   */
  public static function fromYm($year, $month)
  {
    return new SolarSeason($year, $month);
  }

  /**
   * 通過指定日期獲取陽曆季度
   * @param DateTime $date 日期DateTime
   * @return SolarSeason
   */
  public static function fromDate($date)
  {
    $year = (int)date_format($date, 'Y');
    $month = (int)date_format($date, 'n');
    return new SolarSeason($year, $month);
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
   * 獲取當月是第幾季度，從1開始
   * @return int
   */
  public function getIndex()
  {
    return (int)ceil($this->month / SolarSeason::$MONTH_COUNT);
  }

  /**
   * 獲取本季度的月份
   * @return array
   */
  public function getMonths()
  {
    $l = array();
    $index = $this->getIndex() - 1;
    for ($i = 0; $i < SolarSeason::$MONTH_COUNT; $i++) {
      $l[] = new SolarMonth($this->year, SolarSeason::$MONTH_COUNT * $index + $i + 1);
    }
    return $l;
  }

  /**
   * 季度推移
   * @param int $seasons 推移的季度數，負數為倒推
   * @return SolarSeason|null
   */
  public function next($seasons)
  {
    if (0 === $seasons) {
      return new SolarSeason($this->year, $this->month);
    }
    try {
      $date = new DateTime($this->year . '-' . $this->month . '-1');
    } catch (Exception $e) {
      return null;
    }
    $date->modify((SolarSeason::$MONTH_COUNT * $seasons) . ' month');
    return SolarSeason::fromDate($date);
  }

}