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

        if (config('lazy.method') == 'basic') {
            $attributes['data-lazy-image'] = $this->url->asset($url, $secure);
        } else {
            $attributes['data-lazy-file'] = $url;
        }

        $placeholder = $this->getPlaceholder($attributes, $secure);

        unset($attributes['placeholder']);

        return '<img src="' . $placeholder . '"' . $this->attributes($attributes) . '>';
    }

    /**
     * Returns the placeholder file in order of priority
     * @param $attributes
     * @param $secure
     * @return array
     */
    protected function getPlaceholder($attributes, $secure)
    {
        //check to see if there is not a placeholder override
        if (isset($attributes['placeholder'])) {

            return $this->url->asset($attributes['placeholder'], $secure);

        }

        //check to see if there is not a class that requires seperate placeholder
        if (isset($attributes['class'])) {

            $classPlaceholder = $this->hasPlaceholderClass($attributes['class']);

            if ($classPlaceholder != false) return $this->url->asset($classPlaceholder, $secure);
        }

        return $this->url->asset(config('lazy.placeholders.default'), $secure);
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

        $placeholders = config('lazy.placeholders.classes');

        foreach ($placeholders as $key => $value) {
            if (in_array($key, $classes)) return $value;
        }

        return false;
    }


}