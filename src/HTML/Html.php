<?php

namespace Backalley\Html;

class Html extends HtmlConstructor
{
    /**
     * 
     */
    public $html_map;

    /**
     * 
     */
    public function __construct(array $html_map = [], string $charset = null)
    {
        parent::__construct($html_map, $charset);
        $this->set_html_map($html_map);

    }

    /**
     * 
     */
    public function __toString()
    {
        return $this->construct_html();
    }

    /**
     * 
     */
    public function set_html_map($html_map)
    {
        $this->html_map = $html_map;

        return $this;
    }

    /**
     * genterates an html string from 
     * 
     * @param array $html_map
     * @param bool $recall
     * 
     * @return string
     */
    public function construct_html($map = null, $recall = false)
    {
        $html = '';
        static $marked_up;

        if (!$recall) {
            $marked_up = [];
        }

        foreach ($map ?? $this->html_map as $current_element => $definition) {

            if (in_array($current_element, $marked_up)) {
                continue;
            }

            // add values already existing as strings to $html as they may already exist as markup
            if (is_object($definition) && method_exists($definition, '__toString') || is_string($definition)) {
                $html .= $definition;
                $marked_up[] = $current_element;
                continue;
            }

            $html .= parent::open($definition['tag'], $definition['attributes'] ?? '');
            $html .= $definition['content'] ?? '';

            // store children in array to be passed as $html_map argument in recursive call
            if (!empty($children = $definition['children'] ?? null)) {
                foreach ($children as $child) {
                    $child_map[$child] = $this->html_map[$child];
                }

                $html .= $this->construct_html($child_map, true);
            }

            $html .= parent::close($definition['tag']);
            $marked_up[] = $current_element;
        }

        // reset static variables if in initial call stack
        if (!$recall) {
            $marked_up = null;
        }

        return $html;
    }

    /**
     * 
     */
    public static function open(string $tag, $attributes = null, $indent = 0, $new_line = false)
    {
        return parent::open($tag, $attributes, $indent, $new_line);
    }

    /**
     * 
     */
    public static function close(string $tag)
    {
        return parent::close($tag);
    }

    /**
     * 
     */
    public function attributes($attributes_array)
    {
        return parent::parse_attributes($attributes_array);
    }

    /**
     * 
     */
    public static function script($code)
    {
        $tag = '';
        $attributes = [];

        $script = new HtmlConstructor;

        $tag .= $script->open('script', $attributes);
        $tag .= $code;
        $tag .= $script->close('script');
    }
}