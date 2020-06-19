<?php
/**
 * lunar
 * @author 6tail
 */
namespace App\Library;
namespace com\nlf\calendar\util;

use DateTime;

use com\nlf\calendar\util\Holiday;
use com\nlf\calendar\util\LunarUtil;
use com\nlf\calendar\util\SolarUtil;
use com\nlf\calendar\util\SolarConvert;

date_default_timezone_set('PRC');
bcscale(12);

/**
 * 農曆日期
 * @package com\nlf\calendar
 */
class LunarConvert
{
  /**
   * 節氣表，國標以冬至為首個節氣
   * @var array
   */
  private static $JIE_QI = array('冬至', '小寒', '大寒', '立春', '雨水', '驚蟄', '春分', '清明', '穀雨', '立夏', '小滿', '芒種', '夏至', '小暑', '大暑', '立秋', '處暑', '白露', '秋分', '寒露', '霜降', '立冬', '小雪', '大雪');

  /**
   * 黃經週期項
   * @var array
   */
  private static $E10 = array(1.75347045673, 0.00000000000, 0.0000000000, 0.03341656456, 4.66925680417, 6283.0758499914, 0.00034894275, 4.62610241759, 12566.1516999828, 0.00003417571, 2.82886579606, 3.5231183490, 0.00003497056, 2.74411800971, 5753.3848848968, 0.00003135896, 3.62767041758, 77713.7714681205, 0.00002676218, 4.41808351397, 7860.4193924392, 0.00002342687, 6.13516237631, 3930.2096962196, 0.00001273166, 2.03709655772, 529.6909650946, 0.00001324292, 0.74246356352, 11506.7697697936, 0.00000901855, 2.04505443513, 26.2983197998, 0.00001199167, 1.10962944315, 1577.3435424478, 0.00000857223, 3.50849156957, 398.1490034082, 0.00000779786, 1.17882652114, 5223.6939198022, 0.00000990250, 5.23268129594, 5884.9268465832, 0.00000753141, 2.53339053818, 5507.5532386674, 0.00000505264, 4.58292563052, 18849.2275499742, 0.00000492379, 4.20506639861, 775.5226113240, 0.00000356655, 2.91954116867, 0.0673103028, 0.00000284125, 1.89869034186, 796.2980068164, 0.00000242810, 0.34481140906, 5486.7778431750, 0.00000317087, 5.84901952218, 11790.6290886588, 0.00000271039, 0.31488607649, 10977.0788046990, 0.00000206160, 4.80646606059, 2544.3144198834, 0.00000205385, 1.86947813692, 5573.1428014331, 0.00000202261, 2.45767795458, 6069.7767545534, 0.00000126184, 1.08302630210, 20.7753954924, 0.00000155516, 0.83306073807, 213.2990954380, 0.00000115132, 0.64544911683, 0.9803210682, 0.00000102851, 0.63599846727, 4694.0029547076, 0.00000101724, 4.26679821365, 7.1135470008, 0.00000099206, 6.20992940258, 2146.1654164752, 0.00000132212, 3.41118275555, 2942.4634232916, 0.00000097607, 0.68101272270, 155.4203994342, 0.00000085128, 1.29870743025, 6275.9623029906, 0.00000074651, 1.75508916159, 5088.6288397668, 0.00000101895, 0.97569221824, 15720.8387848784, 0.00000084711, 3.67080093025, 71430.6956181291, 0.00000073547, 4.67926565481, 801.8209311238, 0.00000073874, 3.50319443167, 3154.6870848956, 0.00000078756, 3.03698313141, 12036.4607348882, 0.00000079637, 1.80791330700, 17260.1546546904, 0.00000085803, 5.98322631256, 161000.6857376741, 0.00000056963, 2.78430398043, 6286.5989683404, 0.00000061148, 1.81839811024, 7084.8967811152, 0.00000069627, 0.83297596966, 9437.7629348870, 0.00000056116, 4.38694880779, 14143.4952424306, 0.00000062449, 3.97763880587, 8827.3902698748, 0.00000051145, 0.28306864501, 5856.4776591154, 0.00000055577, 3.47006009062, 6279.5527316424, 0.00000041036, 5.36817351402, 8429.2412664666, 0.00000051605, 1.33282746983, 1748.0164130670, 0.00000051992, 0.18914945834, 12139.5535091068, 0.00000049000, 0.48735065033, 1194.4470102246, 0.00000039200, 6.16832995016, 10447.3878396044, 0.00000035566, 1.77597314691, 6812.7668150860, 0.00000036770, 6.04133859347, 10213.2855462110, 0.00000036596, 2.56955238628, 1059.3819301892, 0.00000033291, 0.59309499459, 17789.8456197850, 0.00000035954, 1.70876111898, 2352.8661537718);

  /**
   * 黃經泊松1項
   * @var array
   */
  private static $E11 = array(6283.31966747491, 0.00000000000, 0.0000000000, 0.00206058863, 2.67823455584, 6283.0758499914, 0.00004303430, 2.63512650414, 12566.1516999828, 0.00000425264, 1.59046980729, 3.5231183490, 0.00000108977, 2.96618001993, 1577.3435424478, 0.00000093478, 2.59212835365, 18849.2275499742, 0.00000119261, 5.79557487799, 26.2983197998, 0.00000072122, 1.13846158196, 529.6909650946, 0.00000067768, 1.87472304791, 398.1490034082, 0.00000067327, 4.40918235168, 5507.5532386674, 0.00000059027, 2.88797038460, 5223.6939198022, 0.00000055976, 2.17471680261, 155.4203994342, 0.00000045407, 0.39803079805, 796.2980068164, 0.00000036369, 0.46624739835, 775.5226113240, 0.00000028958, 2.64707383882, 7.1135470008, 0.00000019097, 1.84628332577, 5486.7778431750, 0.00000020844, 5.34138275149, 0.9803210682, 0.00000018508, 4.96855124577, 213.2990954380, 0.00000016233, 0.03216483047, 2544.3144198834, 0.00000017293, 2.99116864949, 6275.9623029906);

  /** 黃經泊松2項 */
  private static $E12 = array(0.00052918870, 0.00000000000, 0.0000000000, 0.00008719837, 1.07209665242, 6283.0758499914, 0.00000309125, 0.86728818832, 12566.1516999828, 0.00000027339, 0.05297871691, 3.5231183490, 0.00000016334, 5.18826691036, 26.2983197998, 0.00000015752, 3.68457889430, 155.4203994342, 0.00000009541, 0.75742297675, 18849.2275499742, 0.00000008937, 2.05705419118, 77713.7714681205, 0.00000006952, 0.82673305410, 775.5226113240, 0.00000005064, 4.66284525271, 1577.3435424478);
  private static $E13 = array(0.00000289226, 5.84384198723, 6283.0758499914, 0.00000034955, 0.00000000000, 0.0000000000, 0.00000016819, 5.48766912348, 12566.1516999828);
  private static $E14 = array(0.00000114084, 3.14159265359, 0.0000000000, 0.00000007717, 4.13446589358, 6283.0758499914, 0.00000000765, 3.83803776214, 12566.1516999828);
  private static $E15 = array(0.00000000878, 3.14159265359, 0.0000000000);
  /** 黃緯週期項 */
  private static $E20 = array(0.00000279620, 3.19870156017, 84334.6615813083, 0.00000101643, 5.42248619256, 5507.5532386674, 0.00000080445, 3.88013204458, 5223.6939198022, 0.00000043806, 3.70444689758, 2352.8661537718, 0.00000031933, 4.00026369781, 1577.3435424478, 0.00000022724, 3.98473831560, 1047.7473117547, 0.00000016392, 3.56456119782, 5856.4776591154, 0.00000018141, 4.98367470263, 6283.0758499914, 0.00000014443, 3.70275614914, 9437.7629348870, 0.00000014304, 3.41117857525, 10213.2855462110);
  private static $E21 = array(0.00000009030, 3.89729061890, 5507.5532386674, 0.00000006177, 1.73038850355, 5223.6939198022);
  /** 離心率 */
  private static $GXC_E = array(0.016708634, -0.000042037, -0.0000001267);
  /** 章動表 */
  private static $ZD = array(2.1824391966, -33.757045954, 0.0000362262, 3.7340E-08, -2.8793E-10, -171996, -1742, 92025, 89, 3.5069406862, 1256.663930738, 0.0000105845, 6.9813E-10, -2.2815E-10, -13187, -16, 5736, -31, 1.3375032491, 16799.418221925, -0.0000511866, 6.4626E-08, -5.3543E-10, -2274, -2, 977, -5, 4.3648783932, -67.514091907, 0.0000724525, 7.4681E-08, -5.7586E-10, 2062, 2, -895, 5, 0.0431251803, -628.301955171, 0.0000026820, 6.5935E-10, 5.5705E-11, -1426, 34, 54, -1, 2.3555557435, 8328.691425719, 0.0001545547, 2.5033E-07, -1.1863E-09, 712, 1, -7, 0, 3.4638155059, 1884.965885909, 0.0000079025, 3.8785E-11, -2.8386E-10, -517, 12, 224, -6, 5.4382493597, 16833.175267879, -0.0000874129, 2.7285E-08, -2.4750E-10, -386, -4, 200, 0, 3.6930589926, 25128.109647645, 0.0001033681, 3.1496E-07, -1.7218E-09, -301, 0, 129, -1, 3.5500658664, 628.361975567, 0.0000132664, 1.3575E-09, -1.7245E-10, 217, -5, -95, 3);

  private $year;

  private $month;

  private $day;

  private $hour;

  private $minute;

  private $second;

  /**
   * 對應陽曆
   * @var Solar
   */
  private $solar;

  /**
   * 相對於基準日的偏移天數
   * @var int
   */
  private $dayOffset;

  /**
   * 時對應的天干下標，0-9
   * @var int
   */
  private $timeGanIndex;

  /**
   * 時對應的地支下標，0-11
   * @var int
   */
  private $timeZhiIndex;

  /**
   * 日對應的天干下標，0-9
   * @var int
   */
  private $dayGanIndex;

  /**
   * 日對應的天干下標（最精確的，供八字用，晚子時算第二天），0-9
   * @var int
   */
  private $dayGanIndexExact;

  /**
   * 日對應的地支下標，0-11
   * @var int
   */
  private $dayZhiIndex;

  /**
   * 日對應的地支下標（最精確的，供八字用，晚子時算第二天），0-9
   * @var int
   */
  private $dayZhiIndexExact;

  /**
   * 月對應的天干下標（以節交接當天起算），0-9
   * @var int
   */
  private $monthGanIndex;

  /**
   * 月對應的地支下標（以節交接當天起算），0-11
   * @var int
   */
  private $monthZhiIndex;

  /**
   * 月對應的天干下標（最精確的，供八字用，以節交接時刻起算），0-9
   * @var int
   */
  private $monthGanIndexExact;

  /**
   * 月對應的地支下標（最精確的，供八字用，以節交接時刻起算），0-11
   * @var int
   */
  private $monthZhiIndexExact;

  /**
   * 年對應的天干下標（國標，以正月初一為起點），0-9
   * @var int
   */
  private $yearGanIndex;

  /**
   * 年對應的地支下標（國標，以正月初一為起點），0-11
   * @var int
   */
  private $yearZhiIndex;

  /**
   * 年對應的天干下標（月干計算用，以立春為起點），0-9
   * @var int
   */
  private $yearGanIndexByLiChun;

  /**
   * 年對應的地支下標（月支計算用，以立春為起點），0-11
   * @var int
   */
  private $yearZhiIndexByLiChun;

  /**
   * 年對應的天干下標（最精確的，供八字用，以立春交接時刻為起點），0-9
   * @var int
   */
  private $yearGanIndexExact;

  /**
   * 年對應的地支下標（最精確的，供八字用，以立春交接時刻為起點），0-11
   * @var int
   */
  private $yearZhiIndexExact;

  /**
   * 周下標，0-6
   * @var int
   */
  private $weekIndex;

  /**
   * 24節氣表（對應陽曆的準確時刻）
   * @var array
   */
  private $jieQi = array();

  function __construct($year, $month, $day, $hour, $minute, $second)
  {
    $this->year = $year;
    $this->month = $month;
    $this->day = $day;
    $this->hour = $hour;
    $this->minute = $minute;
    $this->second = $second;
    $this->dayOffset = LunarUtil::computeAddDays($year, $month, $day);
    $this->solar = $this->toSolar();
    $this->compute();
  }

  /**
   * 轉換為陽曆日期
   * @return Solar|null
   */
  private function toSolar()
  {
    try {
      $date = new DateTime(SolarUtil::$BASE_YEAR . '-' . SolarUtil::$BASE_MONTH . '-' . SolarUtil::$BASE_DAY . ' ' . $this->hour . ':' . $this->minute . ':' . $this->second);
    } catch (Exception $e) {
      return null;
    }
    $date->modify($this->dayOffset . ' day');
    return SolarConvert::fromDate($date);
  }

  /**
   * 通過指定農曆年月日獲取農曆
   * @param int $year 年（農曆）
   * @param int $month 月（農曆），1到12，閏月為負，即閏2月=-2
   * @param int $day 日（農曆），1到31
   * @return Lunar
   */
  public static function fromYmd($year, $month, $day)
  {
    return new LunarConvert($year, $month, $day, 0, 0, 0);
  }

  /**
   * 通過指定農曆年月日時分秒獲取農曆
   * @param int $year 年（農曆）
   * @param int $month 月（農曆），1到12，閏月為負，即閏2月=-2
   * @param int $day 日（農曆），1到31
   * @param int $hour 小時（陽曆）
   * @param int $minute 分鐘（陽曆）
   * @param int $second 秒鐘（陽曆）
   * @return Lunar
   */

  public static function fromYmdH($year, $month, $day, $hour)
  {
    return new LunarConvert($year, $month, $day, $hour, 0, 0);
  }

  public static function fromYmdHms($year, $month, $day, $hour, $minute, $second)
  {
    return new LunarConvert($year, $month, $day, $hour, $minute, $second);
  }

  /**
   * 通過陽曆日期初始化
   * @param DateTime $date 陽曆日期
   * @return Lunar
   */
  public static function fromDate($date)
  {
    $solar = SolarConvert::fromDate($date);
    $y = $solar->getYear();
    $m = $solar->getMonth();
    $d = $solar->getDay();
    if ($y < 2000) {
      $startYear = SolarUtil::$BASE_YEAR;
      $startMonth = SolarUtil::$BASE_MONTH;
      $startDay = SolarUtil::$BASE_DAY;
      $lunarYear = LunarUtil::$BASE_YEAR;
      $lunarMonth = LunarUtil::$BASE_MONTH;
      $lunarDay = LunarUtil::$BASE_DAY;
    } else {
      $startYear = SolarUtil::$BASE_YEAR + 99;
      $startMonth = 1;
      $startDay = 1;
      $lunarYear = LunarUtil::$BASE_YEAR + 99;
      $lunarMonth = 11;
      $lunarDay = 25;
    }
    $diff = 0;
    for ($i = $startYear; $i < $y; $i++) {
      $diff += 365;
      if (SolarUtil::isLeapYear($i)) {
        $diff += 1;
      }
    }
    for ($i = $startMonth; $i < $m; $i++) {
      $diff += SolarUtil::getDaysOfMonth($y, $i);
    }
    $diff += $d - $startDay;
    $lunarDay += $diff;
    $lastDate = LunarUtil::getDaysOfMonth($lunarYear, $lunarMonth);
    while ($lunarDay > $lastDate) {
      $lunarDay -= $lastDate;
      $lunarMonth = LunarUtil::nextMonth($lunarYear, $lunarMonth);
      if ($lunarMonth == 1) {
        $lunarYear++;
      }
      $lastDate = LunarUtil::getDaysOfMonth($lunarYear, $lunarMonth);
    }
    return new LunarConvert($lunarYear, $lunarMonth, $lunarDay, $solar->getHour(), $solar->getMinute(), $solar->getSecond());
  }

  /**
   * 計算節氣表（冬至的太陽黃經是-90度或270度）
   */
  private function computeJieQi()
  {
    //儒略日，冬至在陽曆上一年，所以這裡多減1年以從去年開始
    $jd = 365.2422 * ($this->solar->getYear() - 2001);
    for ($i = 0, $j = count(LunarConvert::$JIE_QI); $i < $j; $i++) {
      $t = doubleval(bcadd(bcadd($this->calJieQi($jd + $i * 15.2, $i * 15 - 90) . '', SolarConvert::$J2000 . ''), bcdiv(8, 24)));
      $this->jieQi[LunarConvert::$JIE_QI[$i]] = SolarConvert::fromJulianDay($t);
    }
  }

  /**
   * 計算干支紀年
   */
  private function computeYear()
  {
    $yearGanIndex = ($this->year + LunarUtil::$BASE_YEAR_GAN_ZHI_INDEX) % 10;
    $yearZhiIndex = ($this->year + LunarUtil::$BASE_YEAR_GAN_ZHI_INDEX) % 12;

    //以立春作為新一年的開始的干支紀年
    $g = $yearGanIndex;
    $z = $yearZhiIndex;

    //精確的干支紀年，以立春交接時刻為準
    $gExact = $yearGanIndex;
    $zExact = $yearZhiIndex;

    if ($this->year === $this->solar->getYear()) {
      //獲取立春的陽曆時刻
      $liChun = $this->jieQi['立春'];
      //立春日期判斷
      if (strcmp($this->solar->toYmd(), $liChun->toYmd()) < 0) {
        $g--;
        if ($g < 0) {
          $g += 10;
        }
        $z--;
        if ($z < 0) {
          $z += 12;
        }
      }
      //立春交接時刻判斷
      if (strcmp($this->solar->toYmdHms(), $liChun->toYmdHms()) < 0) {
        $gExact--;
        if ($gExact < 0) {
          $gExact += 10;
        }
        $zExact--;
        if ($zExact < 0) {
          $zExact += 12;
        }
      }
    }

    $this->yearGanIndex = $yearGanIndex;
    $this->yearZhiIndex = $yearZhiIndex;

    $this->yearGanIndexByLiChun = $g;
    $this->yearZhiIndexByLiChun = $z;

    $this->yearGanIndexExact = $gExact;
    $this->yearZhiIndexExact = $zExact;
  }

  /**
   * 干支紀月計算
   */
  private function computeMonth()
  {
    $start = null;
    //干偏移值（以立春當天起算）
    $gOffset = (($this->yearGanIndexByLiChun % 5 + 1) * 2) % 10;
    //干偏移值（以立春交接時刻起算）
    $gOffsetExact = (($this->yearGanIndexExact % 5 + 1) * 2) % 10;

    //序號：大雪到小寒之間-2，小寒到立春之間-1，立春之後0
    $index = -2;
    foreach (LunarUtil::$JIE as $jie) {
      $end = $this->jieQi[$jie];
      $ymd = $this->solar->toYmd();
      $symd = (null == $start) ? $ymd : $start->toYmd();
      $eymd = $end->toYmd();
      if (strcmp($ymd, $symd) >= 0 && strcmp($ymd, $eymd) < 0) {
        break;
      }
      $start = $end;
      $index++;
    }
    if ($index < 0) {
      $index += 12;
    }

    $this->monthGanIndex = ($index + $gOffset) % 10;
    $this->monthZhiIndex = ($index + LunarUtil::$BASE_MONTH_ZHI_INDEX) % 12;

    $start = null;
    //序號：大雪到小寒之間-2，小寒到立春之間-1，立春之後0
    $indexExact = -2;
    foreach (LunarUtil::$JIE as $jie) {
      $end = $this->jieQi[$jie];
      $time = $this->solar->toYmdHms();
      $stime = null == $start ? $time : $start->toYmdHms();
      $etime = $end->toYmdHms();
      if (strcmp($time, $stime) >= 0 && strcmp($time, $etime) < 0) {
        break;
      }
      $start = $end;
      $indexExact++;
    }
    if ($indexExact < 0) {
      $indexExact += 12;
    }
    $this->monthGanIndexExact = ($indexExact + $gOffsetExact) % 10;
    $this->monthZhiIndexExact = ($indexExact + LunarUtil::$BASE_MONTH_ZHI_INDEX) % 12;
  }

  /**
   * 干支紀日計算
   */
  private function computeDay()
  {
    $addDays = ($this->dayOffset + LunarUtil::$BASE_DAY_GAN_ZHI_INDEX) % 60;
    $dayGanIndex = $addDays % 10;
    $dayZhiIndex = $addDays % 12;

    $this->dayGanIndex = $dayGanIndex;
    $this->dayZhiIndex = $dayZhiIndex;

    $dayGanExact = $dayGanIndex;
    $dayZhiExact = $dayZhiIndex;

    // 晚子時（夜子/子夜）應算作第二天
    $hm = ($this->hour < 10 ? '0' : '') . $this->hour . ':' . ($this->minute < 10 ? '0' : '') . $this->minute;
    if (strcmp($hm, '23:00') >= 0 && strcmp($hm, '23:59') <= 0) {
      $dayGanExact++;
      if ($dayGanExact >= 10) {
        $dayGanExact -= 10;
      }
      $dayZhiExact++;
      if ($dayZhiExact >= 12) {
        $dayZhiExact -= 12;
      }
    }

    $this->dayGanIndexExact = $dayGanExact;
    $this->dayZhiIndexExact = $dayZhiExact;
  }

  /**
   * 干支紀時計算
   */
  private function computeTime()
  {
    $this->timeZhiIndex = LunarUtil::getTimeZhiIndex(($this->hour < 10 ? '0' : '') . $this->hour . ':' . ($this->minute < 10 ? '0' : '') . $this->minute);
    $this->timeGanIndex = ($this->dayGanIndexExact % 5 * 2 + $this->timeZhiIndex) % 10;
  }

  /**
   * 星期計算
   */
  private function computeWeek()
  {
    $this->weekIndex = ($this->dayOffset + LunarUtil::$BASE_WEEK_INDEX) % 7;
  }

  private function compute()
  {
    $this->computeJieQi();
    $this->computeYear();
    $this->computeMonth();
    $this->computeDay();
    $this->computeTime();
    $this->computeWeek();
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

  public function getSolar()
  {
    return $this->solar;
  }

  /**
   * 獲取年份的天干（以正月初一作為新年的開始）
   * @return string 天干，如辛
   */
  public function getYearGan()
  {
    return LunarUtil::$GAN[$this->yearGanIndex + 1];
  }

  /**
   * 獲取年份的天干（以立春當天作為新年的開始）
   *
   * @return string 天干，如辛
   */
  public function getYearGanByLiChun()
  {
    return LunarUtil::$GAN[$this->yearGanIndexByLiChun + 1];
  }

  /**
   * 獲取最精確的年份天干（以立春交接的時刻作為新年的開始）
   *
   * @return string 天干，如辛
   */
  public function getYearGanExact()
  {
    return LunarUtil::$GAN[$this->yearGanIndexExact + 1];
  }

  /**
   * 獲取年份的地支（以正月初一作為新年的開始）
   *
   * @return string 地支，如亥
   */
  public function getYearZhi()
  {
    return LunarUtil::$ZHI[$this->yearZhiIndex + 1];
  }

  /**
   * 獲取年份的地支（以立春當天作為新年的開始）
   *
   * @return string 地支，如亥
   */
  public function getYearZhiByLiChun()
  {
    return LunarUtil::$ZHI[$this->yearZhiIndexByLiChun + 1];
  }

  /**
   * 獲取最精確的年份地支（以立春交接的時刻作為新年的開始）
   *
   * @return string 地支，如亥
   */
  public function getYearZhiExact()
  {
    return LunarUtil::$ZHI[$this->yearZhiIndexExact + 1];
  }

  /**
   * 獲取干支紀年（年柱）（以正月初一作為新年的開始）
   * @return string 年份的干支（年柱），如辛亥
   */
  public function getYearInGanZhi()
  {
    return $this->getYearGan() . $this->getYearZhi();
  }

  /**
   * 獲取干支紀年（年柱）（以立春當天作為新年的開始）
   * @return string 年份的干支（年柱），如辛亥
   */
  public function getYearInGanZhiByLiChun()
  {
    return $this->getYearGanByLiChun() . $this->getYearZhiByLiChun();
  }

  /**
   * 獲取干支紀年（年柱）（以立春交接的時刻作為新年的開始）
   * @return string 年份的干支（年柱），如辛亥
   */
  public function getYearInGanZhiExact()
  {
    return $this->getYearGanExact() . $this->getYearZhiExact();
  }

  /**
   * 獲取干支紀月（月柱）（以節交接當天起算）
   * <p>月天干口訣：甲己丙寅首，乙庚戊寅頭。丙辛從庚寅，丁壬壬寅求，戊癸甲寅居，週而復始流。</p>
   * <p>月地支：正月起寅</p>
   *
   * @return string 干支紀月（月柱），如己卯
   */
  public function getMonthInGanZhi()
  {
    return $this->getMonthGan() . $this->getMonthZhi();
  }

  /**
   * 獲取精確的干支紀月（月柱）（以節交接時刻起算）
   * <p>月天干口訣：甲己丙寅首，乙庚戊寅頭。丙辛從庚寅，丁壬壬寅求，戊癸甲寅居，週而復始流。</p>
   * <p>月地支：正月起寅</p>
   *
   * @return string 干支紀月（月柱），如己卯
   */
  public function getMonthInGanZhiExact()
  {
    return $this->getMonthGanExact() . $this->getMonthZhiExact();
  }

  /**
   * 獲取月天干（以節交接當天起算）
   * @return string 月天干，如己
   */
  public function getMonthGan()
  {
    return LunarUtil::$GAN[$this->monthGanIndex + 1];
  }

  /**
   * 獲取精確的月天干（以節交接時刻起算）
   * @return string 月天干，如己
   */
  public function getMonthGanExact()
  {
    return LunarUtil::$GAN[$this->monthGanIndexExact + 1];
  }

  /**
   * 獲取月地支（以節交接當天起算）
   * @return string 月地支，如卯
   */
  public function getMonthZhi()
  {
    return LunarUtil::$ZHI[$this->monthZhiIndex + 1];
  }

  /**
   * 獲取精確的月地支（以節交接時刻起算）
   * @return string 月地支，如卯
   */
  public function getMonthZhiExact()
  {
    return LunarUtil::$ZHI[$this->monthZhiIndexExact + 1];
  }

  /**
   * 獲取干支紀日（日柱）
   *
   * @return string 干支紀日（日柱），如己卯
   */
  public function getDayInGanZhi()
  {
    return $this->getDayGan() . $this->getDayZhi();
  }

  /**
   * 獲取干支紀日（日柱，晚子時算第二天）
   * @return string 干支紀日（日柱），如己卯
   */
  public function getDayInGanZhiExact()
  {
    return $this->getDayGanExact() . $this->getDayZhiExact();
  }

  /**
   * 獲取日天干
   *
   * @return string 日天干，如甲
   */
  public function getDayGan()
  {
    return LunarUtil::$GAN[$this->dayGanIndex + 1];
  }

  /**
   * 獲取日天干（晚子時算第二天）
   * @return string 日天干，如甲
   */
  public function getDayGanExact()
  {
    return LunarUtil::$GAN[$this->dayGanIndexExact + 1];
  }

  /**
   * 獲取日地支
   *
   * @return string 日地支，如卯
   */
  public function getDayZhi()
  {
    return LunarUtil::$ZHI[$this->dayZhiIndex + 1];
  }

  /**
   * 獲取日地支（晚子時算第二天）
   * @return string 日地支，如卯
   */
  public function getDayZhiExact()
  {
    return LunarUtil::$ZHI[$this->dayZhiIndexExact + 1];
  }

  /**
   * 獲取年生肖（以正月初一起算）
   *
   * @return string 年生肖，如虎
   */
  public function getYearShengXiao()
  {
    return LunarUtil::$SHENG_XIAO[$this->yearZhiIndex + 1];
  }

  /**
   * 獲取年生肖（以立春當天起算）
   *
   * @return string 年生肖，如虎
   */
  public function getYearShengXiaoByLiChun()
  {
    return LunarUtil::$SHENG_XIAO[$this->yearZhiIndexByLiChun + 1];
  }

  /**
   * 獲取精確的年生肖（以立春交接時刻起算）
   *
   * @return string 年生肖，如虎
   */
  public function getYearShengXiaoExact()
  {
    return LunarUtil::$SHENG_XIAO[$this->yearZhiIndexExact + 1];
  }

  /**
   * 獲取月生肖
   *
   * @return string 月生肖，如虎
   */
  public function getMonthShengXiao()
  {
    return LunarUtil::$SHENG_XIAO[$this->monthZhiIndex + 1];
  }

  /**
   * 獲取日生肖
   *
   * @return string 日生肖，如虎
   */
  public function getDayShengXiao()
  {
    return LunarUtil::$SHENG_XIAO[$this->dayZhiIndex + 1];
  }

  /**
   * 獲取時辰生肖
   *
   * @return string 時辰生肖，如虎
   */
  public function getTimeShengXiao()
  {
    return LunarUtil::$SHENG_XIAO[$this->timeZhiIndex + 1];
  }

  /**
   * 獲取中文的年
   *
   * @return string 中文年，如二零零一
   */
  public function getYearInChinese()
  {
    $y = ($this->year . '');
    $s = '';
    for ($i = 0, $j = strlen($y); $i < $j; $i++) {
      $s .= LunarUtil::$NUMBER[ord(substr($y, $i, 1)) - 48];
    }
    return $s;
  }

  /**
   * 獲取中文的月
   *
   * @return string 中文月，如正
   */
  public function getMonthInChinese()
  {
    return ($this->month < 0 ? '閏' : '') . LunarUtil::$MONTH[abs($this->month)];
  }

  /**
   * 獲取中文日
   *
   * @return string 中文日，如初一
   */
  public function getDayInChinese()
  {
    return LunarUtil::$DAY[$this->day];
  }

  /**
   * 獲取時辰（地支）
   * @return string 時辰（地支）
   */
  public function getTimeZhi()
  {
    return LunarUtil::$ZHI[$this->timeZhiIndex + 1];
  }

  /**
   * 獲取時辰（天干）
   * @return string 時辰（天干）
   */
  public function getTimeGan()
  {
    return LunarUtil::$GAN[$this->timeGanIndex + 1];
  }

  /**
   * 獲取時辰干支（時柱）
   * @return string 時辰干支（時柱）
   */
  public function getTimeInGanZhi()
  {
    return $this->getTimeGan() . $this->getTimeZhi();
  }

  /**
   * 獲取季節
   * @return string 農曆季節
   */
  public function getSeason()
  {
    return LunarUtil::$SEASON[abs($this->month)];
  }

  private function mrad($rad)
  {
    $pi2 = bcmul(2, pi());
    $rad = bcmod($rad, $pi2);
    return $rad < 0 ? bcadd($rad, $pi2) : $rad;
  }

  private function gxc($t, $pos)
  {
    $pi = pi();
    $degreePerRad = bcdiv(180, $pi);
    $secondPerRad = bcdiv(180 * 3600, $pi);
    /** 近點 */
    $gxcp = array(bcdiv(102.93735, $degreePerRad), bcdiv(1.71946, $degreePerRad), bcdiv(0.00046, $degreePerRad));
    /** 太平黃經 */
    $gxcl = array(bcdiv(280.4664567, $degreePerRad), bcdiv(36000.76982779, $degreePerRad), bcdiv(0.0003032028, $degreePerRad), bcdiv(bcdiv(1, 49931000), $degreePerRad), bcdiv(bcdiv(-1, 153000000), $degreePerRad));
    /** 光行差常數 */
    $gxck = bcdiv(20.49552, $secondPerRad);
    $t1 = bcdiv($t, 36525);
    $t2 = bcmul($t1, $t1);
    $t3 = bcmul($t2, $t1);
    $t4 = bcmul($t3, $t1);

    $a1 = bcmul($this->str($gxcl[1]), $t1);
    $a2 = bcmul($this->str($gxcl[2]), $t2);
    $a3 = bcmul($this->str($gxcl[3]), $t3);
    $a4 = bcmul($this->str($gxcl[4]), $t4);

    $l = $gxcl[0];
    $l = bcadd($l, $a1);
    $l = bcadd($l, $a2);
    $l = bcadd($l, $a3);
    $l = bcadd($l, $a4);

    $p1 = bcmul($this->str($gxcp[1]), $t1);
    $p2 = bcmul($this->str($gxcp[2]), $t2);

    $p = $gxcp[0];
    $p = bcadd($p, $p1);
    $p = bcadd($p, $p2);

    $e1 = bcmul($this->str(LunarConvert::$GXC_E[1]), $t1);
    $e2 = bcmul($this->str(LunarConvert::$GXC_E[2]), $t2);

    $e = LunarConvert::$GXC_E[0];
    $e = bcadd($e, $e1);
    $e = bcadd($e, $e2);

    $dl = bcsub($l, $pos[0]);
    $dp = bcsub($p, $pos[0]);

    $cose = bcsub(cos($dl), bcmul($e, cos($dp)));
    $sine = bcsub(sin($dl), bcmul($e, sin($dp)));

    $pos[0] = bcsub($pos[0], bcdiv(bcmul($gxck, $cose), $this->str(cos($pos[1]))));

    $gsin = bcmul($gxck, $this->str(sin($pos[1])));

    $pos[1] = bcsub($pos[1], bcmul($gsin, $sine));
    $pos[0] = $this->mrad($pos[0]);
  }

  private function enn($f, $ennt)
  {
    $v = 0;
    for ($i = 0, $j = count($f); $i < $j; $i += 3) {
      $cos = cos(bcadd($f[$i + 1], bcmul($ennt, $f[$i + 2])));
      $v = bcadd($v, bcmul($this->str($f[$i]), $cos));
    }
    return $v;
  }

  /**
   * 計算日心座標中地球的位置
   * @param double $t 儒略日
   * @return array 地球座標
   */
  private function calEarth($t)
  {
    $t1 = bcdiv($t, '365250');
    $r = array(2);
    $t2 = bcmul($t1, $t1);
    $t3 = bcmul($t2, $t1);
    $t4 = bcmul($t3, $t1);
    $t5 = bcmul($t4, $t1);
    $r[0] = $this->mrad($this->enn(LunarConvert::$E10, $t1) + $this->enn(LunarConvert::$E11, $t1) * $t1 + $this->enn(LunarConvert::$E12, $t1) * $t2 + $this->enn(LunarConvert::$E13, $t1) * $t3 + $this->enn(LunarConvert::$E14, $t1) * $t4 + $this->enn(LunarConvert::$E15, $t1) * $t5);
    $r[1] = bcadd($this->enn(LunarConvert::$E20, $t1), bcmul($this->enn(LunarConvert::$E21, $t1), $t1));
    return $r;
  }

  private function str($num)
  {
    if (false !== stripos($num, 'e')) {
      $a = explode('e', strtolower($num));
      return bcmul($a[0], bcpow(10, $a[1]));
    } else {
      return $num . '';
    }
  }

  /**
   * 計算黃經章動
   * @param double $t J2000起算儒略日數
   * @return double 黃經章動
   */
  private function hjzd($t)
  {
    $lon = 0;
    $t1 = bcdiv($t, '36525');
    $t2 = bcmul($t1, $t1);
    $t3 = bcmul($t2, $t1);
    $t4 = bcmul($t3, $t1);
    for ($i = 0, $j = count(LunarConvert::$ZD); $i < $j; $i += 9) {
      $a1 = bcmul($this->str(LunarConvert::$ZD[$i + 1]), $t1);
      $a2 = bcmul($this->str(LunarConvert::$ZD[$i + 2]), $t2);
      $a3 = bcmul($this->str(LunarConvert::$ZD[$i + 3]), $t3);
      $a4 = bcmul($this->str(LunarConvert::$ZD[$i + 4]), $t4);

      $c = bcadd(LunarConvert::$ZD[$i], $a1);
      $c = bcadd($c, $a2);
      $c = bcadd($c, $a3);
      $c = bcadd($c, $a4);

      $a6 = bcmul($this->str(LunarConvert::$ZD[$i + 6]), $t1);
      $lon = bcadd($lon, bcmul(bcadd($this->str(LunarConvert::$ZD[$i + 5]), bcdiv($a6, 10)), sin($c)));
    }
    $lon = bcdiv($lon, bcdiv(180 * 3600 * 10000, pi()));
    return $lon;
  }

  /**
   * 地心座標中的日月位置計算（計算t時刻太陽黃經與角度的差）
   * @param double $t J2000起算儒略日數
   * @param double $rad 弧度
   * @return double 角度差
   */
  private function calRad($t, $rad)
  {
    // 計算太陽真位置(先算出日心座標中地球的位置)
    $pos = $this->calEarth($t);
    $pos[0] = bcadd($pos[0], pi());
    // 轉為地心座標
    $pos[1] = bcsub(0, $pos[1]);
    // 補週年光行差
    $this->gxc($t, $pos);
    // 補黃經章動
    $pos[0] = bcadd($pos[0], $this->hjzd($t));
    return $this->mrad(bcsub($rad, $pos[0]));
  }

  /**
   * 太陽黃經達某角度的時刻計算(用於節氣計算)
   * @param double $t1 J2000起算儒略日數
   * @param double $degree 角度
   * @return double 時刻
   */
  private function calJieQi($t1, $degree)
  {
    // 對於節氣計算,應滿足t在t1到t1+360天之間,對於Y年第n個節氣(n=0是春分),t1可取值Y*365.2422+n*15.2
    $pi = pi();
    $t2 = $t1;
    $t = 0;;
    // 在t1到t2範圍內求解(范氣360天範圍),結果置於t
    $t2 += 360;
    // 待搜索目標角
    $rad = bcdiv(bcmul($degree, $pi), 180);
    // 利用截弦法計算
    // v1,v2為t1,t2時對應的黃經
    $v1 = $this->calRad($t1, $rad);
    $v2 = $this->calRad($t2, $rad);
    // 減2pi作用是將週期性角度轉為連續角度
    if ($v1 < $v2) {
      $v2 = bcsub($v2, bcmul(2, $pi));
    }
    // k是截弦的斜率
    $k = 1;
    // 快速截弦求根,通常截弦三四次就已達所需精度
    for ($i = 0; $i < 10; $i++) {
      // 算出斜率
      $k2 = bcdiv(bcsub($v2, $v1), bcsub($t2, $t1));
      // 差商可能為零,應排除
      if (abs($k2) > 1e-15) {
        $k = $k2;
      }
      $t = bcsub($t1, bcdiv($v1, $k));
      // 直線逼近法求根(直線方程的根)
      $v = $this->calRad($t, $rad);
      // 一次逼近后,v1就已接近0,如果很大,則應減1周
      if ($v > 1) {
        $v = bcsub($v, bcmul(2, $pi));
      }
      // 已達精度
      if (abs($v) < 1e-8) {
        break;
      }
      $t1 = $t2;
      $v1 = $v2;
      $t2 = $t;
      // 下一次截弦
      $v2 = $v;
    }
    return $t;
  }

  /**
   * 獲取節
   *
   * @return string 節
   */
  public function getJie()
  {
    foreach (LunarUtil::$JIE as $jie) {
      $d = $this->jieQi[$jie];
      if ($d->getYear() === $this->solar->getYear() && $d->getMonth() === $this->solar->getMonth() && $d->getDay() === $this->solar->getDay()) {
        return $jie;
      }
    }
    return '';
  }

  /**
   * 獲取氣
   *
   * @return string 氣
   */
  public function getQi()
  {
    foreach (LunarUtil::$QI as $qi) {
      $d = $this->jieQi[$qi];
      if ($d->getYear() === $this->solar->getYear() && $d->getMonth() === $this->solar->getMonth() && $d->getDay() === $this->solar->getDay()) {
        return $qi;
      }
    }
    return '';
  }

  /**
   * 獲取星期，0代表週日，1代表週一
   *
   * @return int 0123456
   */
  public function getWeek()
  {
    return $this->weekIndex;
  }

  /**
   * 獲取星期的中文
   *
   * @return string 日一二三四五六
   */
  public function getWeekInChinese()
  {
    return SolarUtil::$WEEK[$this->getWeek()];
  }

  /**
   * 獲取宿
   *
   * @return string 宿
   */
  public function getXiu()
  {
    return LunarUtil::$XIU[$this->getDayZhi() . $this->getWeek()];
  }

  /**
   * 獲取宿吉兇
   *
   * @return string 吉/兇
   */
  public function getXiuLuck()
  {
    return LunarUtil::$XIU_LUCK[$this->getXiu()];
  }

  /**
   * 獲取宿歌訣
   *
   * @return string 宿歌訣
   */
  public function getXiuSong()
  {
    return LunarUtil::$XIU_SONG[$this->getXiu()];
  }

  /**
   * 獲取政
   *
   * @return string 政
   */
  public function getZheng()
  {
    return LunarUtil::$ZHENG[$this->getXiu()];
  }

  /**
   * 獲取動物
   * @return string 動物
   */
  public function getAnimal()
  {
    return LunarUtil::$ANIMAL[$this->getXiu()];
  }

  /**
   * 獲取宮
   * @return string 宮
   */
  public function getGong()
  {
    return LunarUtil::$GONG[$this->getXiu()];
  }

  /**
   * 獲取獸
   * @return string 獸
   */
  public function getShou()
  {
    return LunarUtil::$SHOU[$this->getGong()];
  }

  /**
   * 獲取節日，有可能一天會有多個節日
   *
   * @return array 節日列表，如春節
   */
  public function getFestivals()
  {
    $l = array();
    if (!empty(LunarUtil::$FESTIVAL[$this->month . '-' . $this->day])) {
      $l[] = LunarUtil::$FESTIVAL[$this->month . '-' . $this->day];
    }
    return $l;
  }

  /**
   * 獲取非正式的節日，有可能一天會有多個節日
   *
   * @return array 非正式的節日列表，如中元節
   */
  public function getOtherFestivals()
  {
    $l = array();
    if (!empty(LunarUtil::$OTHER_FESTIVAL[$this->month . '-' . $this->day])) {
      $l[] = LunarUtil::$OTHER_FESTIVAL[$this->month . '-' . $this->day];
    }
    return $l;
  }

  /**
   * 獲取彭祖百忌天干
   * @return string 彭祖百忌天干
   */
  public function getPengZuGan()
  {
    return LunarUtil::$PENG_ZU_GAN[$this->dayGanIndex + 1];
  }

  /**
   * 獲取彭祖百忌地支
   * @return string 彭祖百忌地支
   */
  public function getPengZuZhi()
  {
    return LunarUtil::$PENG_ZU_ZHI[$this->dayZhiIndex + 1];
  }

  /**
   * 獲取喜神方位
   * @return string 喜神方位，如艮
   */
  public function getPositionXi()
  {
    return LunarUtil::$POSITION_XI[$this->dayGanIndex + 1];
  }

  /**
   * 獲取喜神方位描述
   * @return string 喜神方位描述，如東北
   */
  public function getPositionXiDesc()
  {
    return LunarUtil::$POSITION_DESC[$this->getPositionXi()];
  }

  /**
   * 獲取陽貴神方位
   * @return string 陽貴神方位，如艮
   */
  public function getPositionYangGui()
  {
    return LunarUtil::$POSITION_YANG_GUI[$this->dayGanIndex + 1];
  }

  /**
   * 獲取陽貴神方位描述
   * @return string 陽貴神方位描述，如東北
   */
  public function getPositionYangGuiDesc()
  {
    return LunarUtil::$POSITION_DESC[$this->getPositionYangGui()];
  }

  /**
   * 獲取陰貴神方位
   * @return string 陰貴神方位，如艮
   */
  public function getPositionYinGui()
  {
    return LunarUtil::$POSITION_YIN_GUI[$this->dayGanIndex + 1];
  }

  /**
   * 獲取陰貴神方位描述
   * @return string 陰貴神方位描述，如東北
   */
  public function getPositionYinGuiDesc()
  {
    return LunarUtil::$POSITION_DESC[$this->getPositionYinGui()];
  }

  /**
   * 獲取福神方位
   * @return string 福神方位，如艮
   */
  public function getPositionFu()
  {
    return LunarUtil::$POSITION_FU[$this->dayGanIndex + 1];
  }

  /**
   * 獲取福神方位描述
   * @return string 福神方位描述，如東北
   */
  public function getPositionFuDesc()
  {
    return LunarUtil::$POSITION_DESC[$this->getPositionFu()];
  }

  /**
   * 獲取財神方位
   * @return string 財神方位，如艮
   */
  public function getPositionCai()
  {
    return LunarUtil::$POSITION_CAI[$this->dayGanIndex + 1];
  }

  /**
   * 獲取財神方位描述
   * @return string 財神方位描述，如東北
   */
  public function getPositionCaiDesc()
  {
    return LunarUtil::$POSITION_DESC[$this->getPositionCai()];
  }

  /**
   * 獲取沖
   * @return string 沖，如申
   */
  public function getChong()
  {
    return $this->getDayChong();
  }

  /**
   * 獲取日沖
   * @return string 日沖，如申
   */
  public function getDayChong()
  {
    return LunarUtil::$CHONG[$this->dayZhiIndex + 1];
  }

  /**
   * 獲取時沖
   * @return string 時沖，如申
   */
  public function getTimeChong()
  {
    return LunarUtil::$CHONG[$this->timeZhiIndex + 1];
  }

  /**
   * 獲取無情之克的沖天干
   * @return string 無情之克的沖天干，如甲
   */
  public function getChongGan()
  {
    return $this->getDayChongGan();
  }

  /**
   * 獲取無情之克的日沖天干
   * @return string 無情之克的日沖天干，如甲
   */
  public function getDayChongGan()
  {
    return LunarUtil::$CHONG_GAN[$this->dayGanIndex + 1];
  }

  /**
   * 獲取無情之克的時沖天干
   * @return string 無情之克的時沖天干，如甲
   */
  public function getTimeChongGan()
  {
    return LunarUtil::$CHONG_GAN[$this->timeGanIndex + 1];
  }

  /**
   * 獲取有情之克的沖天干
   * @return string 有情之克的沖天干，如甲
   */
  public function getChongGanTie()
  {
    return $this->getDayChongGanTie();
  }

  /**
   * 獲取有情之克的日沖天干
   * @return string 有情之克的日沖天干，如甲
   */
  public function getDayChongGanTie()
  {
    return LunarUtil::$CHONG_GAN_TIE[$this->dayGanIndex + 1];
  }

  /**
   * 獲取有情之克的時沖天干
   * @return string 有情之克的時沖天干，如甲
   */
  public function getTimeChongGanTie()
  {
    return LunarUtil::$CHONG_GAN_TIE[$this->timeGanIndex + 1];
  }

  /**
   * 獲取沖生肖
   * @return string 沖生肖，如猴
   */
  public function getChongShengXiao()
  {
    return $this->getDayChongShengXiao();
  }

  /**
   * 獲取日沖生肖
   * @return string 日沖生肖，如猴
   */
  public function getDayChongShengXiao()
  {
    $chong = $this->getDayChong();
    for ($i = 0, $j = count(LunarUtil::$ZHI); $i < $j; $i++) {
      if (strcmp(LunarUtil::$ZHI[$i], $chong) === 0) {
        return LunarUtil::$SHENG_XIAO[$i];
      }
    }
    return '';
  }

  /**
   * 獲取時沖生肖
   * @return string 時沖生肖，如猴
   */
  public function getTimeChongShengXiao()
  {
    $chong = $this->getTimeChong();
    for ($i = 0, $j = count(LunarUtil::$ZHI); $i < $j; $i++) {
      if (strcmp(LunarUtil::$ZHI[$i], $chong) === 0) {
        return LunarUtil::$SHENG_XIAO[$i];
      }
    }
    return '';
  }

  /**
   * 獲取沖描述
   * @return string 沖描述，如(壬申)猴
   */
  public function getChongDesc()
  {
    return $this->getDayChongDesc();
  }

  /**
   * 獲取日沖描述
   * @return string 日沖描述，如(壬申)猴
   */
  public function getDayChongDesc()
  {
    return '(' . $this->getDayChongGan() . $this->getDayChong() . ')' . $this->getDayChongShengXiao();
  }

  /**
   * 獲取時沖描述
   * @return string 時沖描述，如(壬申)猴
   */
  public function getTimeChongDesc()
  {
    return '(' . $this->getTimeChongGan() . $this->getTimeChong() . ')' . $this->getTimeChongShengXiao();
  }

  /**
   * 獲取煞
   * @return string 煞，如北
   */
  public function getSha()
  {
    return $this->getDaySha();
  }

  /**
   * 獲取日煞
   * @return string 日煞，如北
   */
  public function getDaySha()
  {
    return LunarUtil::$SHA[$this->getDayZhi()];
  }

  /**
   * 獲取時煞
   * @return string 時煞，如北
   */
  public function getTimeSha()
  {
    return LunarUtil::$SHA[$this->getTimeZhi()];
  }

  /**
   * 獲取年納音
   * @return string 年納音，如劍鋒金
   */
  public function getYearNaYin()
  {
    return LunarUtil::$NAYIN[$this->getYearInGanZhi()];
  }

  /**
   * 獲取月納音
   * @return string 月納音，如劍鋒金
   */
  public function getMonthNaYin()
  {
    return LunarUtil::$NAYIN[$this->getMonthInGanZhi()];
  }

  /**
   * 獲取日納音
   * @return string 日納音，如劍鋒金
   */
  public function getDayNaYin()
  {
    return LunarUtil::$NAYIN[$this->getDayInGanZhi()];
  }

  /**
   * 獲取時辰納音
   * @return string 時辰納音，如劍鋒金
   */
  public function getTimeNaYin()
  {
    return LunarUtil::$NAYIN[$this->getTimeInGanZhi()];
  }

  /**
   * 獲取八字，男性也稱乾造，女性也稱坤造（以立春交接時刻作為新年的開始）
   * @return array 八字（男性也稱乾造，女性也稱坤造）
   */
  public function getBaZi()
  {
    $l = array(4);
    $l[] = $this->getYearInGanZhiExact();
    $l[] = $this->getMonthInGanZhiExact();
    $l[] = $this->getDayInGanZhiExact();
    $l[] = $this->getTimeInGanZhi();
    return $l;
  }

  /**
   * 獲取八字五行
   * @return array 八字五行
   */
  public function getBaZiWuXing()
  {
    $baZi = $this->getBaZi();
    $l = array(count($baZi));
    foreach ($baZi as $ganZhi) {
      $gan = substr($ganZhi, 0, 1);
      $zhi = substr($ganZhi, 1);
      $l[] = LunarUtil::$WU_XING_GAN[$gan] . LunarUtil::$WU_XING_ZHI[$zhi];
    }
    return $l;
  }

  /**
   * 獲取八字納音
   * @return array 八字納音
   */
  public function getBaZiNaYin()
  {
    $baZi = $this->getBaZi();
    $l = array(count($baZi));
    foreach ($baZi as $ganZhi) {
      $l[] = LunarUtil::$NAYIN[$ganZhi];
    }
    return $l;
  }

  /**
   * 獲取八字天干十神，日柱十神為日主，其餘三柱根據天干十神表查詢
   * @return array 八字天干十神
   */
  public function getBaZiShiShenGan()
  {
    $baZi = $this->getBaZi();
    $yearGan = substr($baZi[0], 0, 1);
    $monthGan = substr($baZi[1], 0, 1);
    $dayGan = substr($baZi[2], 0, 1);
    $timeGan = substr($baZi[3], 0, 1);
    $l = array(count($baZi));
    $l[] = LunarUtil::$SHI_SHEN_GAN[$dayGan . $yearGan];
    $l[] = LunarUtil::$SHI_SHEN_GAN[$dayGan . $monthGan];
    $l[] = '日主';
    $l[] = LunarUtil::$SHI_SHEN_GAN[$dayGan . $timeGan];
    return $l;
  }

  /**
   * 獲取八字地支十神，根據地支十神表查詢
   * @return array 八字地支十神
   */
  public function getBaZiShiShenZhi()
  {
    $baZi = $this->getBaZi();
    $dayGan = substr($baZi[2], 0, 1);
    $l = array(count($baZi));
    foreach ($baZi as $ganZhi) {
      $zhi = substr($ganZhi, 1);
      $l[] = LunarUtil::$SHI_SHEN_ZHI[$dayGan . $zhi . LunarUtil::$ZHI_HIDE_GAN[$zhi][0]];
    }
    return $l;
  }

  /**
   * 獲取十二執星：建、除、滿、平、定、執、破、危、成、收、開、閉。當月支與日支相同即為建，依次類推
   * @return string 執星
   */
  public function getZhiXing()
  {
    $offset = $this->dayZhiIndex - $this->monthZhiIndex;
    if ($offset < 0) {
      $offset += 12;
    }
    return LunarUtil::$ZHI_XING[$offset + 1];
  }

  /**
   * 獲取值日天神
   * @return string 值日天神
   */
  public function getDayTianShen()
  {
    $monthZhi = $this->getMonthZhi();
    $offset = LunarUtil::$ZHI_TIAN_SHEN_OFFSET[$monthZhi];
    return LunarUtil::$TIAN_SHEN[($this->dayZhiIndex + $offset) % 12 + 1];
  }

  /**
   * 獲取值時天神
   * @return string 值時天神
   */
  public function getTimeTianShen()
  {
    $dayZhi = $this->getDayZhiExact();
    $offset = LunarUtil::$ZHI_TIAN_SHEN_OFFSET[$dayZhi];
    return LunarUtil::$TIAN_SHEN[($this->timeZhiIndex + $offset) % 12 + 1];
  }

  /**
   * 獲取值日天神型別：黃道/黑道
   * @return string 值日天神型別：黃道/黑道
   */
  public function getDayTianShenType()
  {
    return LunarUtil::$TIAN_SHEN_TYPE[$this->getDayTianShen()];
  }

  /**
   * 獲取值時天神型別：黃道/黑道
   * @return string 值時天神型別：黃道/黑道
   */
  public function getTimeTianShenType()
  {
    return LunarUtil::$TIAN_SHEN_TYPE[$this->getTimeTianShen()];
  }

  /**
   * 獲取值日天神吉兇
   * @return string 吉/兇
   */
  public function getDayTianShenLuck()
  {
    return LunarUtil::$TIAN_SHEN_TYPE_LUCK[$this->getDayTianShenType()];
  }

  /**
   * 獲取值時天神吉兇
   * @return string 吉/兇
   */
  public function getTimeTianShenLuck()
  {
    return LunarUtil::$TIAN_SHEN_TYPE_LUCK[$this->getTimeTianShenType()];
  }

  /**
   * 獲取逐日胎神方位
   * @return string 逐日胎神方位
   */
  public function getDayPositionTai()
  {
    $offset = $this->dayGanIndex - $this->dayZhiIndex;
    if ($offset < 0) {
      $offset += 12;
    }
    return LunarUtil::$POSITION_TAI_DAY[$offset * 5 + $this->dayGanIndex];
  }

  /**
   * 獲取逐月胎神方位，閏月無
   * @return string 逐月胎神方位
   */
  public function getMonthPositionTai()
  {
    if ($this->month < 0) {
      return '';
    }
    return LunarUtil::$POSITION_TAI_MONTH[$this->month - 1];
  }

  /**
   * 獲取每日宜
   * @return array 宜
   */
  public function getDayYi()
  {
    return LunarUtil::getDayYi($this->getMonthInGanZhiExact(), $this->getDayInGanZhi());
  }

  /**
   * 獲取時宜
   * @return array 宜
   */
  public function getTimeYi()
  {
    return LunarUtil::getTimeYi($this->getDayInGanZhiExact(), $this->getTimeInGanZhi());
  }

  /**
   * 獲取每日忌
   * @return array 忌
   */
  public function getDayJi()
  {
    return LunarUtil::getDayJi($this->getMonthInGanZhiExact(), $this->getDayInGanZhi());
  }

  /**
   * 獲取時忌
   * @return array 忌
   */
  public function getTimeJi()
  {
    return LunarUtil::getTimeJi($this->getDayInGanZhiExact(), $this->getTimeInGanZhi());
  }

  /**
   * 獲取日吉神（宜趨），如果沒有，返回["無"]
   * @return array 吉神
   */
  public function getDayJiShen()
  {
    return LunarUtil::getDayJiShen($this->getMonth(), $this->getDayInGanZhi());
  }

  /**
   * 獲取日兇煞（宜忌），如果沒有，返回["無"]
   * @return array 兇煞
   */
  public function getDayXiongSha()
  {
    return LunarUtil::getDayXiongSha($this->getMonth(), $this->getDayInGanZhi());
  }

  /**
   * 獲取節氣表（節氣名稱:陽曆），節氣交接時刻精確到秒，以冬至開頭，按先後順序排列
   * @return array 節氣表
   */
  public function getJieQiTable()
  {
    return $this->jieQi;
  }

  public function toFullString()
  {
    $s = '';
    $s .= $this;
    $s .= ' ';
    $s .= $this->getYearInGanZhi();
    $s .= '(';
    $s .= $this->getYearShengXiao();
    $s .= ')年 ';
    $s .= $this->getMonthInGanZhi();
    $s .= '(';
    $s .= $this->getMonthShengXiao();
    $s .= ')月 ';
    $s .= $this->getDayInGanZhi();
    $s .= '(';
    $s .= $this->getDayShengXiao();
    $s .= ')日 ';
    $s .= $this->getTimeZhi();
    $s .= '(';
    $s .= $this->getTimeShengXiao();
    $s .= ')時 納音[';
    $s .= $this->getYearNaYin();
    $s .= ' ';
    $s .= $this->getMonthNaYin();
    $s .= ' ';
    $s .= $this->getDayNaYin();
    $s .= ' ';
    $s .= $this->getTimeNaYin();
    $s .= '] 星期';
    $s .= $this->getWeekInChinese();/*
    foreach ($this->getFestivals() as $f) {
      $s .= ' (' . $f . ')';
    }
    foreach ($this->getOtherFestivals() as $f) {
      $s .= ' (' . $f . ')';
    }*/
    $jq = $this->getJie() . $this->getQi();
    if (strlen($jq) > 0) {
      $s .= ' (' . $jq . ')';
    }
    $s .= ' ';
    $s .= $this->getGong();
    $s .= '方';
    $s .= $this->getShou();
    $s .= ' 星宿[';
    $s .= $this->getXiu();
    $s .= $this->getZheng();
    $s .= $this->getAnimal();
    $s .= '](';
    $s .= $this->getXiuLuck();
    $s .= ') 彭祖百忌[';
    $s .= $this->getPengZuGan();
    $s .= ' ';
    $s .= $this->getPengZuZhi();
    $s .= '] 喜神方位[';
    $s .= $this->getPositionXi();
    $s .= '](';
    $s .= $this->getPositionXiDesc();
    $s .= ') 陽貴神方位[';
    $s .= $this->getPositionYangGui();
    $s .= '](';
    $s .= $this->getPositionYangGuiDesc();
    $s .= ') 陰貴神方位[';
    $s .= $this->getPositionYinGui();
    $s .= '](';
    $s .= $this->getPositionYinGuiDesc();
    $s .= ') 福神方位[';
    $s .= $this->getPositionFu();
    $s .= '](';
    $s .= $this->getPositionFuDesc();
    $s .= ') 財神方位[';
    $s .= $this->getPositionCai();
    $s .= '](';
    $s .= $this->getPositionCaiDesc();
    $s .= ') 沖[';
    $s .= $this->getChongDesc();
    $s .= '] 煞[';
    $s .= $this->getSha();
    $s .= ']';
    return $s;
  }

  public function __toString()
  {
    return $this->getYearInChinese() . '年' . $this->getMonthInChinese() . '月' . $this->getDayInChinese();
  }

}
