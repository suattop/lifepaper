<?php
/**
 * lunar
 *
 * @author 6tail
 */

namespace App\Library;

namespace com\nlf\calendar\util;

/**
 * 節假日
 */
class Holiday
{
    /**
     * 日期，YYYY-MM-DD格式
     *
     * @var string
     */
    private $day;

    /**
     * 名稱，如：國慶
     *
     * @var string
     */
    private $name;

    /**
     * 是否調休，即是否要上班
     *
     * @var bool
     */
    private $work = false;

    /**
     * 關聯的節日，YYYY-MM-DD格式
     *
     * @var string
     */
    private $target;

    public function __construct($day, $name, $work, $target)
    {
        if (strpos($day, '-')) {
            $this->day = $day;
        } else {
            $this->day = substr($day, 0, 4).'-'.substr($day, 4, 2).'-'.substr($day, 6);
        }
        $this->name = $name;
        $this->work = $work;
        if (strpos($day, '-')) {
            $this->target = $target;
        } else {
            $this->target = substr($target, 0, 4).'-'.substr($target, 4, 2).'-'.substr($target, 6);
        }
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setWork($work)
    {
        $this->work = $work;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isWork()
    {
        return $this->work;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function __toString()
    {
        return $this->day.' '.$this->name.($this->work ? '調休' : '').' '.$this->target;
    }
}
