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
 * 陽曆工具，基準日期為1901年1月1日，對應農曆1900年十一月十一
 * @package com\nlf\calendar\util
 */
class SolarUtil
{
  /**
   * 陽曆基準年
   * @var int
   */
  public static $BASE_YEAR = 1901;

  /**
   * 陽曆基準月
   * @var int
   */
  public static $BASE_MONTH = 1;

  /**
   * 陽曆基準日
   * @var int
   */
  public static $BASE_DAY = 1;

  /**
   * 星期
   * @var array
   */
  public static $WEEK = array('日', '一', '二', '三', '四', '五', '六');

  /**
   * 每月天數
   * @var array
   */
  public static $DAYS_OF_MONTH = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

  /**
   * 星座
   * @var array
   */
  public static $XING_ZUO = array('白羊', '金牛', '雙子', '巨蟹', '獅子', '處女', '天秤', '天蝎', '射手', '摩羯', '水瓶', '雙魚');

  /**
   * 日期對應的節日
   * @var array
   */
  public static $FESTIVAL = array(
    '1-1' => '元旦節',
    '2-14' => '情人節',
    '3-8' => '婦女節',
    '3-12' => '植樹節',
    '3-15' => '消費者權益日',
    '4-1' => '愚人節',
    '5-1' => '勞動節',
    '5-4' => '青年節',
    '6-1' => '兒童節',
    '7-1' => '建黨節',
    '8-1' => '建軍節',
    '9-10' => '教師節',
    '10-1' => '國慶節',
    '12-24' => '平安夜',
    '12-25' => '聖誕節'
  );

  /**
   * 幾月第幾個星期幾對應的節日
   * @var array
   */
  public static $WEEK_FESTIVAL = array(
    '5-2-0' => '母親節',
    '6-3-0' => '父親節',
    '11-4-4' => '感恩節'
  );

  /**
   * 日期對應的非正式節日
   * @var array
   */
  public static $OTHER_FESTIVAL = array(
    '1-8' => array('周恩來逝世紀念日'),
    '1-10' => array('中國公安110宣傳日'),
    '1-21' => array('列寧逝世紀念日'),
    '1-26' => array('國際海關日'),
    '2-2' => array('世界濕地日'),
    '2-4' => array('世界抗癌日'),
    '2-7' => array('京漢鐵路罷工紀念'),
    '2-10' => array('國際氣象節'),
    '2-19' => array('鄧小平逝世紀念日'),
    '2-21' => array('國際母語日'),
    '2-24' => array('第三世界青年日'),
    '3-1' => array('國際海豹日'),
    '3-3' => array('全國愛耳日'),
    '3-5' => array('周恩來誕辰紀念日', '中國青年志願者服務日'),
    '3-6' => array('世界青光眼日'),
    '3-12' => array('孫中山逝世紀念日'),
    '3-14' => array('馬克思逝世紀念日'),
    '3-17' => array('國際航海日'),
    '3-18' => array('全國科技人才活動日'),
    '3-21' => array('世界森林日', '世界睡眠日'),
    '3-22' => array('世界水日'),
    '3-23' => array('世界氣象日'),
    '3-24' => array('世界防治結核病日'),
    '4-2' => array('國際兒童圖書日'),
    '4-7' => array('世界衛生日'),
    '4-22' => array('列寧誕辰紀念日'),
    '4-23' => array('世界圖書和版權日'),
    '4-26' => array('世界智慧財產權日'),
    '5-3' => array('世界新聞自由日'),
    '5-5' => array('馬克思誕辰紀念日'),
    '5-8' => array('世界紅十字日'),
    '5-11' => array('世界肥胖日'),
    '5-23' => array('世界讀書日'),
    '5-27' => array('上海解放日'),
    '5-31' => array('世界無煙日'),
    '6-5' => array('世界環境日'),
    '6-6' => array('全國愛眼日'),
    '6-8' => array('世界海洋日'),
    '6-11' => array('中國人口日'),
    '6-14' => array('世界獻血日'),
    '7-1' => array('香港迴歸紀念日'),
    '7-7' => array('中國人民抗日戰爭紀念日'),
    '7-11' => array('世界人口日'),
    '8-5' => array('恩格斯逝世紀念日'),
    '8-6' => array('國際電影節'),
    '8-12' => array('國際青年日'),
    '8-22' => array('鄧小平誕辰紀念日'),
    '9-3' => array('中國抗日戰爭勝利紀念日'),
    '9-8' => array('世界掃盲日'),
    '9-9' => array('毛澤東逝世紀念日'),
    '9-14' => array('世界清潔地球日'),
    '9-18' => array('九一八事變紀念日'),
    '9-20' => array('全國愛牙日'),
    '9-21' => array('國際和平日'),
    '9-27' => array('世界旅遊日'),
    '10-4' => array('世界動物日'),
    '10-10' => array('辛亥革命紀念日'),
    '10-13' => array('中國少年先鋒隊誕辰日'),
    '10-25' => array('抗美援朝紀念日'),
    '11-12' => array('孫中山誕辰紀念日'),
    '11-28' => array('恩格斯誕辰紀念日'),
    '12-1' => array('世界艾滋病日'),
    '12-12' => array('西安事變紀念日'),
    '12-13' => array('南京大屠殺紀念日'),
    '12-26' => array('毛澤東誕辰紀念日')
  );

  /**
   * 是否閏年
   * @param int $year 年
   * @return bool 是否閏年
   */
  public static function isLeapYear($year)
  {
    $leap = false;
    if ($year % 4 == 0) {
      $leap = true;
    }
    if ($year % 100 == 0) {
      $leap = false;
    }
    if ($year % 400 == 0) {
      $leap = true;
    }
    return $leap;
  }

  /**
   * 獲取某年某月有多少天
   * @param int $year 年
   * @param int $month 月
   * @return int 天數
   */
  public static function getDaysOfMonth($year, $month)
  {
    $d = SolarUtil::$DAYS_OF_MONTH[$month - 1];
    //公曆閏年2月多一天
    if ($month == 2 && SolarUtil::isLeapYear($year)) {
      $d++;
    }
    return $d;
  }

  /**
   * 獲取某年某月有多少周
   * @param int $year 年
   * @param int $month 月
   * @param int $start 星期幾作為一週的開始，1234560分別代表星期一至星期天
   * @return int 週數
   */
  public static function getWeeksOfMonth($year, $month, $start)
  {
    $days = SolarUtil::getDaysOfMonth($year, $month);
    $week = date('w', strtotime($year . '-' . $month . '-1'));
    return ceil(($days + $week - $start) / count(SolarUtil::$WEEK));
  }
}