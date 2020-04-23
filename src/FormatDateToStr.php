<?php

namespace Newteng\FormatDate;


use Newteng\FormatDate\Exceptions\InvalidArgumentException;
use Newteng\FormatDate\Exceptions\InvalidValueException;

class FormatDateToStr
{
    private $timezone;
    private $supportedTypes = ['timestamp', 'time_string'];

    public function __construct($timezone = 'PRC')
    {
        $this->timezone = $timezone;
    }

    public function transform($time, string $type = 'time_string')
    {
        if (!\in_array(\strtolower($type), $this->supportedTypes)) {
            throw new InvalidArgumentException('Invalid type value(timestamp/time_string): ' . $type);
        }

        switch (\strtolower($type)) {
            case 'timestamp':
                if (!is_int($time) || (strtotime(date('Y-m-d  H:i:s', $time)) !== $time)) {
                    throw new InvalidValueException('Invalid timestamp value: ' . $time);
                }
                $timestamp = $time;
                break;
            default:
            case 'time_string':
                if (!($timestamp = strtotime($time))) {
                    throw new InvalidValueException('Invalid timestamp value: ' . $time);
                }
                break;
        }

        return $this->format($timestamp);
    }

    /**
     * timestamp format date/time string
     * @param $targetTime
     * @return false|string
     */
    private function format($targetTime)
    {
        date_default_timezone_set($this->timezone);
        $calculatedTime = time() - $targetTime;
        switch ($calculatedTime) {
            case $calculatedTime <= 60:
                $msg = '刚刚';
                break;
            case $calculatedTime > 60 && $calculatedTime <= 60 * 60:
                $msg = floor($calculatedTime / 60) . ' 分钟前';
                break;
            case $calculatedTime > 60 * 60 && $calculatedTime <= 24 * 60 * 60:
                $msg = date('Ymd', $targetTime) == date('Ymd', time())
                    ? '今天 ' . date('H:i', $targetTime)
                    : '昨天 ' . date('H:i', $targetTime);
                break;
            case $calculatedTime > 24 * 60 * 60 && $calculatedTime <= 2 * 24 * 60 * 60:
                $msg = date('Ymd', $targetTime) + 1 == date('Ymd', time())
                    ? '昨天 ' . date('H:i', $targetTime)
                    : '前天 ' . date('H:i', $targetTime);
                break;
            case $calculatedTime > 2 * 24 * 60 * 60 && $calculatedTime <= 12 * 30 * 24 * 60 * 60:
                $msg = date('Y', $targetTime) == date('Y', time())
                    ? date('m-d H:i', $targetTime)
                    : date('Y-m-d H:i', $targetTime);
                break;
            default:
                $msg = date('Y-m-d H:i', $targetTime);
        }

        return $msg;
    }
}