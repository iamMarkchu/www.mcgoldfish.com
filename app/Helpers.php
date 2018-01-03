<?php
use Carbon\Carbon;
if(!function_exists('diff_time'))
{
    /**
     * @param \Carbon\Carbon $datetime
     * @return string
     */
    function diff_time($datetime){
        if(Carbon::getLocale() !== 'zh')
            Carbon::setLocale('zh');
        return $datetime->diffForHumans();
    }
}