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
     * @param  string $url
     * @param  string $alt
     * @param  array $attributes
     * @param  bool $secure
     * @return string
     */
    public function image($url, $alt = null, $attributes = array(), $secure = null)
    {
        $attributes['alt'] = $alt;

        if(config('method') == 'basic'){
            $attributes['data-lazy-image'] = $this->url->asset($url, $secure);
        }else{
            $attributes['data-lazy-file'] = $url;
        }

        if (isset($attributes['placeholder'])) {  //check to see if there is not a placeholder override

            $placeholder = $this->url->asset($attributes['placeholder'], $secure);

            unset($attributes['placeholder']);
        } elseif (isset($attributes['class'])) { //check to see if there is not a class that requires seperate placeholder

            $classPlaceholder = $this->hasPlaceholderClass($attributes['class']);

            if ($classPlaceholder != false) $placeholder = $this->url->asset($classPlaceholder, $secure);
        } else {
            $placeholder = $this->url->asset(config('placeholders.default'), $secure);
        }

        return '<img src="' . $placeholder . '"' . $this->attributes($attributes) . '>';
    }


    /**
     * This checks to see if the list of classes matches any of the configured
     * placeholders and returns first one.
     * @param $classAttr
     * @return bool
     */
    protected function hasPlaceholderClass($classAttr)
    {
        $classes = explode(' ', $classAttr);

        $placeholders = config('placeholders.classes');

        foreach ($placeholders as $key => $value) {
            if (in_array($key, $classes)) return $value;
        }

        return false;
    }
}