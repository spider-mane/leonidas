<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Html;

trait HtmlMapConstructorTrait
{
    /**
     * 
     */
    public function set_html_map($html_map)
    {
        $this->html_map = $this->parse_html_map($html_map);

        return $this;
    }

    /**
     * Reconstructs a raw html_map into one parsable by $this->construct_html()
     * 
     * @param array $html_map
     */
    public function parse_html_map($html_map)
    {
        foreach ($html_map as $element) {
            if (is_string($element)) {
                continue;
            }

            if (!isset($element['tag'])) {
                $parse = true;
                break;
            }
        }

        if (!isset($parse)) {
            return $html_map;
        }

        foreach ($html_map as $current_element => $definition) { // begin $html_map loop
            if (!isset($definition['children'])) {
                continue;
            }

            $html_map[$current_element]['children'] = is_array($definition['children']) ? $definition['children'] : [$definition['children']];
            $children = $html_map[$current_element]['children'];

            // loop through array of $current_element children
            foreach ($children as $blueprint_node) {

                // don't iterate through children that already exist in proper linear context
                if (isset($html_map[$blueprint_node]['tag'])) {
                    continue;
                }

                // begin loop through each item in the blueprint node array
                foreach ($html_map[$blueprint_node] as $child_blueprint => $node_map) {
                    if (!isset($node_map['instances'])) {
                        throw new Error('you know you fucked up right?');
                    }


                    // convert children attribute to array if it exists and is
                    // not already an array
                    if (isset($node_map['children'])) {
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

                        // insert new child into root level of $html_map
                        $html_map["{$blueprint_node}-{$child_blueprint}-{$instance}"] = $new_child;
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
                foreach ($lost_children ?? [] as $pointer => $genetics) {

                    // look for parent amongst siblings
                    foreach ($lost_children as $maybe_child => $family_values) {
                        if (isset($family_values['children'])) {

                            // move to the next iteration if the element is referenced as a child of any other element
                            if (in_array($pointer, $family_values['children'])) {
                                continue;
                            }

                            // add any new elements that make it this far to $current_element['children'] only if
                            // they have not already been added (because it will add them again!)
                            // die(var_dump($html_map[$current_element]['children']));

                            if (!in_array($maybe_child, $html_map[$current_element]['children'])) {
                                $html_map[$current_element]['children'][] = $maybe_child;
                            }
                        }
                    }
                }

                // remove blueprint node name from $current_element['children']
                $blueprint_node_index = array_search($blueprint_node, $html_map[$current_element]['children']);
                unset($html_map[$current_element]['children'][$blueprint_node_index]);

                // remove blueprint from element_arry
                unset($html_map[$blueprint_node]);

            } // end $current_element['children'] loop

        } // end $html_map loop

        return $this->parse_html_map($html_map);
    }
}
