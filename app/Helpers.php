<?php
use Carbon\Carbon;
use App\Tools\Baidu\Translate;
if(!function_exists('diff_time'))
{
    /**
     * @param \Carbon\Carbon $datetime
     * @return string
     */
    function diff_time($datetime)
    {
        if(Carbon::getLocale() !== 'zh')
            Carbon::setLocale('zh');
        return $datetime->diffForHumans();
    }
}

if(!function_exists('get_year'))
{
    function get_year()
    {
        $dt = Carbon::now();
        $dt->addDays(3);
        return $dt->year;
    }
}

if(!function_exists('generate_url'))
{
    function generate_url($title)
    {
        $tl = new Translate();
        $from = 'zh';
        $to = 'en';
        $result = $tl->handle($title, $from, $to);
        $words = $result['trans_result'][0]['dst'];

        // 将特殊字符替换掉
        $reg = '/[^A-Za-z0-9|^\s]/';
        $words = preg_replace($reg, '', $words);
        // 将连续空格变成单空格
        $reg = '/\s+/';
        $words = preg_replace($reg, ' ', $words);
        // 全部小写
        $words = strtolower($words);
        // 空格转成 -
        $words = str_replace(' ', '-', $words);
        return $words;
    }
}