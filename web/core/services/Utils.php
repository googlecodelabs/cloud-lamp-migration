<?php
/**
 * time_elapsed_string()
 *
 * Zachary Johnson
 * http://www.zachstronaut.com/posts/2009/01/20/php-relative-date-time-string.html
 */
function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1) {
        return '0 seconds';
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

function set_relative_time($list){
    foreach ($list as $key => $listItem) {
            $listItem['created_at'] = time_elapsed_string(strtotime($listItem['created_at']));
            $list[$key] = $listItem;
        }
    return $list;
}