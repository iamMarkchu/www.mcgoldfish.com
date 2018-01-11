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
}