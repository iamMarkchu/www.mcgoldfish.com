<?php
namespace App\Tools;
use Parsedown;
class Markdown extends Parsedown
{

    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);
        $image['element']['attributes']['data-echo'] = $image['element']['attributes']['src'];
        $image['element']['attributes']['class'] = 'img';
        return $image;
    }

    protected function inlineLink($excerpt)
    {
        $link = parent::inlineLink($excerpt);
        if(strpos($excerpt['context'], '!') !== 0)
        {
            $link['element']['attributes']['target'] = '_blank';
            if(strpos($link['element']['attributes']['href'], config('app.url')) === false)
            {
                $link['element']['attributes']['rel'] = 'nofollow';
                $link['element']['attributes']['href'] = config('app.url') .'/link?target='. urlencode($link['element']['attributes']['href']);
            }
        }
        return $link;
    }
}