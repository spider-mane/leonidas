<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Html;

class Html
{
    public $element_array = [
        // 'root' => [
            // ...properties
            // 'child' => [
                // ...properties
                // 'decendant'[
                    // ...properties
                    // ...decendants...
                // ]
            // ]
        // ]
    ];

    public $html;

    public $charset;

    public $self_closing_tags = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    public $whitespace_sensitive_tags = [
        'textarea',
    ];

    /**
     * 
     */
    public function __construct($element_array, $charset = null)
    {
        $this->element_array = $element_array;

        $this->html = $this->construct_element($this->element_array);
    }

    /**
     * 
     */
    public function set_charset()
    {
        // code here
    }

    public function set_element($element)
    {
        $this->element = $element;
    }

    /**
     * starting point of the process of creating the data structure necessary
     * rendering the element. the primary purpose of this method is to provide
     * an api to abstract out the need to explicitly set attrubutes needed for
     * any front end functionality. regardless of whether or not any such api is
     * required or provided, use this method to call parse_attributes()
     */
    // abstract function parse_args($element);// : array;

    /**
     * this method shoud recieve a formatted data structure parse it recursively
     * based on whether or not the current array element has a key labed
     * 'children' with a non empty value. If the condition is true, it should
     * store the closing tag in an array. Any element that does not meet said
     * condition for recursive parsing must automaticcaly 
     * 
     * a custom defined method that anticipates and accordingly establishes the
     * element's structure is required as an intermidiary between the construct_element()
     * and parse_attributes() methods
     */
    public function construct_element($element_array, &$el_str = '', &$closing_tags = [], $parsed = false)
    {
        // store array provided at initial function call
        static $element_cache;

        // store array of elements that have been processes
        static $marked_up;

        //
        static $closed_out;

        /**
         * have element array parsed to ensure proper format
         */
        if (!$parsed) {
            $element_array = $this->parse_element_array($element_array);
            $element_cache = $element_array;
            $marked_up = [];
            $closed_out = [];
        }

        // loop through $element_array
        foreach ($element_array as $current_element => $definition) {

            if (in_array($current_element, $marked_up)) {
                continue;
            }

            if (is_string($definition)) {
                $el_str .= $definition;
                $marked_up[] = $current_element;
                continue;
            }

            $open = $this->opening_tag($definition['tag'], $definition['attributes'] ?? '');
            $close = $this->closing_tag($definition['tag']);

            $el_str .= $open;

            if (array_key_exists('content', $definition)) {
                $el_str .= $definition['content'];
            }

            $closing_tags[$current_element] = $close;


            // close out elements without children
            if (empty($definition['children']) && !in_array($current_element, $closed_out)) {
                $el_str .= $close;
                $closed_out[] = $current_element;
            }

            $marked_up[] = $current_element;
            // store children in array to be individually passed as argument in recursion
            if (!empty($definition['children'])) {

                foreach ($definition['children'] as $child) {
                    $next_element[$child] = $element_cache[$child];
                }

                break;
            }
        }
        

        // recursively parse nested children
        if (isset($next_element)) {

            foreach ($next_element as $key => $next_up) {

                if (!in_array($key, $marked_up)) {
                    $thats_meta[$key] = $next_up;
                    $this->construct_element($thats_meta, $el_str, $closing_tags, true);
                }
            }
        }

        // insert closing tag for parent level elements
        // even outside of loop context, $current_element will be any element with children
        if (!in_array($current_element, $closed_out) && !is_string($definition)) {
            $el_str .= $close;
            $closed_out[] = $current_element;
        }


        // recursively call function until all elements have been parsed
        if (!$parsed && count($element_cache) !== count($marked_up)) {
            $this->construct_element($element_array, $el_str, $closing_tags, true);
        }

        // if (count($element_array) > 0) {
        //     $this->construct_element($element_array, $el_str, $closing_tags, true);
        // }

        // set all static variables to null if in initial call stack
        if (!$parsed) {
            $marked_up = null;
            $element_cache = null;
        }

        return $el_str;
    }

    /**
     * 
     */
    public function construct_element_with_map($order, $element_array, &$el_str = '')
    {
        // code here
    }

    /**
     * 
     */
    public function parse_attributes($attributes_array, &$attr_str = '')
    {
        // static $attr_str = '';

        foreach ($attributes_array as $attr => $val) {

            if (is_string($val) || is_int($val)) {
                $val = is_string($val) ? "\"{$val}\"" : $val;
                $attr_str .= " {$attr}={$val}";
                continue;
            }

            if (is_bool($val) && $val === true) {
                $attr_str .= " {$attr}=\"{$attr}\"";
                continue;
            }

            // val is array of boolean values
            if (is_array($val) && $attr === 'boolean_attributes') {
                foreach ($val as $boolean_attr) {
                    $attr_str .= " {$boolean_attr}";
                }
                continue;
            }

             // $val represents token list
            if (is_array($val) && isset($val[0])) {
                $attr_str .= " {$attr}=\"";

                $i = 0;

                foreach ($val as $thing) {
                    if ($i++ === 0) {
                        $attr_str .= "{$thing}";
                    } else {
                        $attr_str .= " {$thing}";
                    }
                }

                $attr_str .= "\""; // add closing quote
                continue;
            }

            // $val represents a map
            if (is_array($val)) {
                foreach ($val as $set => $setval) {
                    // static::parse_attributes(["{$attr}-{$set}" => $setval]);
                    $this->parse_attributes(["{$attr}-{$set}" => $setval], $attr_str);
                }
                continue;
            }
        }

        return ltrim($attr_str);
    }

    /**
     * Reconstructs an array that meets the specifications of the HTML_Element API into one that is parsable by $this->construct_element()
     * 
     * @param array $element_array
     */
    public function parse_element_array($element_array)
    {
        foreach ($element_array as $element) {
            if (is_string($element)) {
                continue;
            }

            if (!array_key_exists('tag', $element)) {
                $parse = true;
                break;
            }
        }

        if (!isset($parse)) {
            return $element_array;
        }

        foreach ($element_array as $current_element => $definition) { // begin $element_array loop
            if (!array_key_exists('children', $definition)) {
                continue;
            }

            $element_array[$current_element]['children'] = is_array($definition['children']) ? $definition['children'] : [$definition['children']];
            $children = $element_array[$current_element]['children'];

            // loop through array of $current_element children
            foreach ($children as $blueprint_node) {

                // don't iterate through children that already exist in proper linear context
                if (array_key_exists('tag', $element_array[$blueprint_node])) {
                    continue;
                }

                // begin loop through each item in the blueprint node array
                foreach ($element_array[$blueprint_node] as $child_blueprint => $node_map) {
                    if (!array_key_exists('instances', $node_map)) {
                        throw new Error('you know you fucked up right?');
                    }


                    // convert children attribute to array if it exists and is
                    // not already an array
                    if (array_key_exists('children', $node_map)) {
                        $node_map['children'] = is_array($node_map['children']) ? $node_map['children'] : [$node_map['children']];
                    }

                    
                    // loop through array of instances and convert them to the a
                    // structure parsable into html markup using values from $node_map
                    foreach ($node_map['instances'] as $instance => $children_definition) {
                        
                        // get children specified in blueprint
                        $instance_children = $node_map['children'] ?? [];

                        // create the element definition
                        $new_child = [
                            'tag' => $node_map['tag'],
                            'content' => $children_definition['content'] ?? '',
                            'attributes' => $children_definition['attributes'] ?? null,
                        ];

                        /**
                         * new elements are to be namespaced begining with the
                         * root name followed by the blueprint node name and
                         * ending with the its index in the instances array
                         * 
                         * as a result children can be predicted as the name
                         * will be the same save for the blueprint node name
                         */
                        foreach ($instance_children as $instance_child_blueprint) {
                            $new_child['children'][] = "{$blueprint_node}-{$instance_child_blueprint}-{$instance}";
                        }

                        // create an array of new children to add top level
                        // elements to the 'children' property of $current_element
                        $lost_children["{$blueprint_node}-{$child_blueprint}-{$instance}"] = $new_child;

                        // insert new child into root level of $element_array
                        $element_array["{$blueprint_node}-{$child_blueprint}-{$instance}"] = $new_child;
                    }

                } // end loop through each item in the blueprint node array


                /**
                 * for every new element created, check to see if it is
                 * referenced as a child of any of the other new elements
                 * 
                 * if it is not listed as a child of any other new element,
                 * append it by key to $current_element['children']
                 * 
                 * note: $real child is only declared in order to have
                 * access to the key $pointer
                 */
                foreach ($lost_children as $pointer => $genetics) {

                    // look for parent amongst siblings
                    foreach ($lost_children as $maybe_child => $family_values) {
                        if (array_key_exists('children', $family_values)) {

                            // move to the next iteration if the element is referenced as a child of any other element
                            if (in_array($pointer, $family_values['children'])) {
                                continue;
                            }

                            // add any new elements that make it this far to $current_element['children'] only if
                            // they have not already been added (because it will add them again!)
                            // die(var_dump($element_array[$current_element]['children']));

                            if (!in_array($maybe_child, $element_array[$current_element]['children'])) {
                                $element_array[$current_element]['children'][] = $maybe_child;
                            }
                        }
                    }
                }

                // remove blueprint node name from $current_element['children']
                $blueprint_node_index = array_search($blueprint_node, $element_array[$current_element]['children']);
                unset($element_array[$current_element]['children'][$blueprint_node_index]);

                // remove blueprint from element_arry
                unset($element_array[$blueprint_node]);

            } // end $current_element['children'] loop

        } // end $element_array loop

        return $this->parse_element_array($element_array);
    }

    /**
     * 
     */
    public function opening_tag(string $tag, $attributes, $indent = 0, $new_line = false)
    {
        if (!is_string($attributes) && is_array($attributes)) {
            $attributes = $this->parse_attributes($attributes);
        }

        $attributes = !empty($attributes) ? " {$attributes}" : '';

        $slash = in_array($tag, $this->self_closing_tags) ? ' /' : '';

        if ($new_line === true) {
            $new_line = !in_array($this->whitespace_sensitive_tags) ? "\n" : '';
        } else {
            $new_line = '';
        }

        return "<{$tag}{$attributes}{$slash}>{$new_line}";
    }

    /**
     * 
     */
    public function closing_tag($tag)
    {
        // return !in_array($tag, $this->self_closing_tags) ? "</{$tag}>" : '';

        if (in_array($tag, $this->self_closing_tags)) {
            return '';
        }

        return "</{$tag}>";
    }

    public function indent_tag($tag, $level)
    {
        // code here
    }

    public function add_new_line()
    {
        // code here
    }
}