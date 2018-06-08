<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 6/9/2018
 * Time: 1:26 AM
 */
use Carbon\Carbon;
use App\Tools\Baidu\Translate;
use Illuminate\Support\Facades\Storage;
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

        if (App::environment('local'))
            $words = $title;
        return str_slug($words);
    }
}

if (!function_exists('upload'))
{
    function upload($file, $name)
    {
        return Storage::disk('public')->putFile($name, $file);
    }
}