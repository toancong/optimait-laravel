<?php
function DateDiff($date1, $date2)
{
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval;
}

function weekNo($date)
{
    $dateObj = new DateTime($date);
    return $dateObj->format("W");
}

function yearNo($date)
{
    $dateObj = new DateTime($date);
    return $dateObj->format("Y");
}

function formatDateDiff($interval, $separator = ', ') {

    $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals

    $format = array();
    if($interval->y !== 0) {
        $format[] = "%y ".$doPlural($interval->y, "year");
    }
    if($interval->m !== 0) {
        $format[] = "%m ".$doPlural($interval->m, "month");
    }
    if($interval->d !== 0) {
        $format[] = "%d ".$doPlural($interval->d, "day");
    }
    if($interval->h !== 0) {
        $format[] = "%h ".$doPlural($interval->h, "hour");
    }
    if($interval->i !== 0) {
        $format[] = "%i ".$doPlural($interval->i, "minute");
    }
    if($interval->s !== 0) {
        if(!count($format)) {
            return "less than a minute ago";
        } else {
            $format[] = "%s ".$doPlural($interval->s, "second");
        }
    }

    // We use the two biggest parts
    if(count($format) > 1) {
        $format = array_shift($format)." ".$separator." ".array_shift($format);
    } else {
        $format = array_pop($format);
    }

    // Prepend 'since ' or whatever you like
    return $interval->format($format);
}

function NiceTime($date)
{

    if (empty($date)) {
        return "No date provided";
    }

    $periods = array("Second", "Minute", "Hour", "Day", "Week", "Month", "Year", "Decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();
    $unix_date = strtotime($date);

    // check validity of date
    if (empty($unix_date)) {
        return "Bad date";
    }

    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "Ago";

    } else {
        $difference = $unix_date - $now;
        $tense = "From Now";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }
    return "$difference $periods[$j] {$tense}";


}


function x_week_range($date)
{
    $ts = strtotime($date);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start),
        date('Y-m-d', strtotime('next saturday', $start)));
}


function LastWeek($format = "Y-m-d")
{
    $previous_week = strtotime("-1 week +1 day");

    $start_week = strtotime("last sunday midnight", $previous_week);
    $end_week = strtotime("next saturday", $start_week);

    $start_week = date($format, $start_week);
    $end_week = date($format, $end_week);

    return array($start_week, $end_week);
}