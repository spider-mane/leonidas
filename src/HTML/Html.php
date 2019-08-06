<?php

namespace Backalley\Html;

class Html extends AbstractHtmlElementConstructor
{
    /**
     *
     */
    public $htmlMap;

    /**
     *
     */
    public function __construct(array $htmlMap = [])
    {
        $this->setHtmlMap($htmlMap);
    }

    /**
     *
     */
    public function setHtmlMap($htmlMap)
    {
        $this->htmlMap = $htmlMap;

        return $this;
    }

    /**
     * genterates an html string from array of element definitions
     *
     * 'tag' => string
     * 'attributes' => array || string
     * 'content' => string
     * 'children' => array
     *
     * @param array $html_map
     * @param bool $recall
     *
     * @return string
     */
    public function constructHtml($map = null, $recall = false)
    {
        $html = '';
        static $markedUp;

        if (!$recall) {
            $markedUp = [];
        }

        foreach ($map ?? $this->htmlMap as $currentElement => $definition) {

            if (in_array($currentElement, $markedUp)) {
                continue;
            }

            // add values already existing as strings to $html as they may already exist as markup
            if (is_object($definition) && method_exists($definition, '__toString') || is_string($definition)) {
                $html .= $definition;
                $markedUp[] = $currentElement;
                continue;
            }

            $html .= parent::open($definition['tag'], $definition['attributes'] ?? '');
            $html .= $definition['content'] ?? '';

            // store children in array to be passed as $html_map argument in recursive call
            if (!empty($children = $definition['children'] ?? null)) {
                foreach ($children as $child) {
                    $child_map[$child] = $this->htmlMap[$child];
                }

                $html .= $this->constructHtml($child_map, true);
            }

            $html .= parent::close($definition['tag']);
            $markedUp[] = $currentElement;
        }

        // reset static variables if in initial call stack
        if (!$recall) {
            $markedUp = null;
        }

        return $html;
    }

    /**
     *
     */
    public static function open(string $tag, $attributes = null, $indent = 0, $newLine = false)
    {
        return parent::open($tag, $attributes, $indent, $newLine);
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
    public static function tag(string $tag, string $content = '', $attributes = null)
    {
        return static::open($tag, $attributes) . $content . static::close($tag);
    }

    /**
     *
     */
    public function attributes($attrubutesArray)
    {
        return parent::parseAttributes($attrubutesArray);
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->constructHtml();
    }
}
