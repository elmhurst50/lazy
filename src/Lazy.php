<?php

namespace samjoyce777\lazy;
use Illuminate\Html\HtmlBuilder;

/**
 * Class Lazy
 * @package samjoyce777\lazy
 */
class Lazy extends HtmlBuilder
{

    /**
     * Generate an HTML image element with lazy loading in mind.
     *
     * @param  string  $url
     * @param  string  $alt
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public function image($url, $alt = null, $attributes = array(), $secure = null)
    {
        $attributes['alt'] = $alt;

        return '<img src="'.$this->url->asset($url, $secure).'"'.$this->attributes($attributes).'>';
    }

}